<?php

namespace DC\Repository;

use DC\Entity\Task;
use DC\Repository\Exception\DbErrorException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Task|null find($id, $lockMode = null, $lockVersion = null)
 * @method Task|null findOneBy(array $criteria, array $orderBy = null)
 * @method Task[]    findAll()
 * @method Task[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    /**
     * @param int $userId
     * @param \DateTime $fromDate
     * @param \DateTime $toDate
     * @return Task[]
     */
    public function findUserTasksBetweenDates(int $userId, \DateTime $fromDate, \DateTime $toDate, $hydrate = true)
    {
        $builder = $this->getEntityManager()
            ->createQueryBuilder();

        $builder
            ->select('t')
            ->from(Task::class, 't')
            ->where('t.userId = :userId')
            ->andWhere(
                $builder->expr()->between(
                    't.startDate',
                    ':from',
                    ':to'
                )
            )->orderBy('t.id','ASC')
            ->setParameter('userId', $userId)
            ->setParameter('from', $fromDate->format('Y-m-d'))
            ->setParameter('to', $toDate->format('Y-m-d'));

        return $builder->getQuery()->getResult();
    }

    /**
     * @param int $userId
     * @param string $title
     * @param \DateTime $startDate
     * @param int|null $id
     * @param string|null $description
     * @return Task
     * @throws DbErrorException
     */
    public function saveTask(int $userId, string $title, \DateTime $startDate, string $description = null, int $id = null): Task
    {
        $now = new \DateTime();

        $entity = (new Task())
            ->setUpdatedAt($now)
            ->setUserId($userId)
            ->setTitle($title)
            ->setStartDate($startDate)
            ->setDescription($description);

        if (!$id) {
            $entity->setCreatedAt($now);
        } else {
            $entity->setId($id);
        }

        try {
            $this->getEntityManager()->persist($entity);
            $this->getEntityManager()->flush();

            return $entity;
        } catch (ORMException $e) {
            throw new DbErrorException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param int $id
     * @throws DbErrorException
     */
    public function deleteTask(int $id)
    {
        $task = $this->find($id);

        if ($task) {
            try {
                $this->getEntityManager()->remove($task);
            } catch (ORMException $e) {
                throw new DbErrorException($e->getMessage(), $e->getCode(), $e);
            }
        }
    }
}
