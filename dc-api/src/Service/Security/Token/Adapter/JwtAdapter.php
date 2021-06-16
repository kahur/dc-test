<?php

namespace DC\Service\Security\Token\Adapter;

use DC\Service\Security\Token\Adapter\Exception\ExpiredTokenException;
use DC\Service\Security\Token\Adapter\Exception\MissingDataException;
use DC\Service\Security\Token\Adapter\Exception\UnsupportedAlgorithmException;
use DC\Service\Security\Token\Adapter\Exception\UnsupportedDataFormatException;
use DC\Service\Security\Token\Interfaces\AdapterInterface;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use function Sodium\add;

/**
 * This adapter is for integration with PHP-JWT token
 * https://github.com/firebase/php-jwt
 *
 * Class JwtAdapter
 * @package DC\Service\Security\Token\Adapter
 */
class JwtAdapter implements AdapterInterface
{
    /**
     * List of supported algorithms
     */
    private const SUPPORTED_ALGORITHMS = [
        'HS256',
        'RS256'
    ];

    /**
     *
     */
    private const REQUIRED_DATA_FIELDS = [
        'expiration'
    ];

    /**
     * Default algorithm
     */
    private const DEFAULT_ALGHORITHM = 'HS256';

    /**
     * @var string key is used to set secret or private key from certificate depends on algorithm
     */
    private $key;

    /**
     * @var string
     */
    private $issuer;

    /**
     * @var string
     */
    private $audience;

    /**
     * @var string
     */
    private $subject;

    /**
     * JwtAdapter constructor.
     * @param string $key
     */
    public function __construct(
        string $key,
        string $issuer,
        string $audience = null,
        string $subject = null
    )
    {
        $this->key = $key;
        $this->issuer = $issuer;
        $this->audience = $audience;
        $this->subject = $subject;
    }

    /**
     * @param string|null $algorithm
     * @return string
     * @throws UnsupportedAlgorithmException
     */
    protected function getAlgorithm(string $algorithm = null): string
    {
        if (!$algorithm) {
            return self::DEFAULT_ALGHORITHM;
        }

        if (!in_array($algorithm, self::SUPPORTED_ALGORITHMS)) {
            throw new UnsupportedAlgorithmException('Algorithm ' . $algorithm . ' is not supported');
        }

        return $algorithm;
    }

    /**
     * @param $data
     * @param string|null $algorithm
     * @return string
     * @throws MissingDataException
     * @throws UnsupportedAlgorithmException
     * @throws UnsupportedDataFormatException
     */
    public function encode($data, string $algorithm = null): string
    {
        $algorithm = $this->getAlgorithm($algorithm);
        if (!is_array($data)) {
            throw new UnsupportedDataFormatException('Data must be in array');
        }

        $this->validateData($data);
        $expiration = new \DateTime();
        $expiration->add(new \DateInterval('PT' . $data['expiration'] . 'H'));

        //unset expiration
        unset($data['expiration']);

        $payload = $this->getTokenPayload($data, $expiration);

        return JWT::encode($payload, $this->key, $algorithm);
    }

    /**
     * @param $token
     * @param string|null $algorithm
     * @return array|null
     * @throws ExpiredTokenException
     */
    public function decode($token, string $algorithm = null)
    {
        try {
            $jwtData = JWT::decode($token, $this->key, self::SUPPORTED_ALGORITHMS);
        } catch (ExpiredException $e) {
            throw new ExpiredTokenException($e->getMessage());
        }

        if (isset($jwtData[0])) {
            return (array) $jwtData[0];
        }

        return null;
    }

    /**
     * @param $token
     * @param string|null $algorithm
     * @throws ExpiredTokenException
     */
    public function validate($token, string $algorithm = null)
    {
        $this->decode($token, $algorithm);
        // we have nothing to validate as JWT validates the expiration itself
    }

    /**
     * @param array $data
     * @throws MissingDataException
     */
    protected function validateData(array $data): void
    {
        $keys = array_keys($data);
        $diff = array_diff(self::REQUIRED_DATA_FIELDS, $keys);

        if (!empty($diff)) {
            throw new MissingDataException('Missing data excpected fields: ' .
                implode(self::REQUIRED_DATA_FIELDS) . ' got: ' . implode($keys));
        }
    }

    /**
     * @param array $data
     * @param \DateTime $expiration
     * @return array
     */
    protected function getTokenPayload(array $data, \DateTime $expiration): array
    {
        $payload = [
            'iss' => $this->issuer,
            'exp' => $expiration->getTimestamp(),
            'iat' => (new \DateTime())->getTimestamp()
        ];

        if ($this->subject) {
            $payload['sub'] = $this->subject;
        }

        if ($this->audience) {
            $payload['aud'] = $this->audience;
        }

        // add or replace default values of JWT
        foreach ($data as $key => $value) {
            $payload[$key] = $value;
        }

        return $payload;
    }
}