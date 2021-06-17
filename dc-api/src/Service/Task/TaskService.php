<?php

namespace DC\Service\Task;

use DC\Entity\Task;
use DC\Repository\TaskRepository;
use DC\Service\Task\Exception\InvalidDataException;
use DC\Service\Task\Validator\TaskValidator;

class TaskService
{
    /**
     * @var TaskRepository
     */
    protected $taskRepository;

    /**
     * @var TaskValidator
     */
    protected $taskValidator;

    /**
     * TaskService constructor.
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository, TaskValidator $taskValidator)
    {
        $this->taskRepository = $taskRepository;
        $this->taskValidator = $taskValidator;
    }

    /**
     * @param int $userId
     * @return \DC\Entity\Task[]|array
     */
    public function getUserDailyTasks(int $userId)
    {
        $now = new \DateTime();
        $tomorrow = (new \DateTime())->add(new \DateInterval('P1D'));

        return $this->taskRepository->findUserTasksBetweenDates($userId, $now, $tomorrow);
    }

    /**
     * @param int $userId
     * @param array $data
     * @return Task
     * @throws InvalidDataException
     * @throws \DC\Repository\Exception\DbErrorException
     */
    public function createTask(int $userId, array $data): Task
    {
        $validationResult = $this->taskValidator->validate($data);

        if ($validationResult->count() > 0) {
            throw new InvalidDataException((string) $validationResult);
        }

        return $this->taskRepository->saveTask($userId, $data['title'], new \DateTime($data['start_date']), $data['description']);
    }

    /**
     * @param int $id
     * @param int $userId
     * @param array $data
     * @return Task
     * @throws InvalidDataException
     * @throws \DC\Repository\Exception\DbErrorException
     */
    public function updateTask(int $id, int $userId, array $data): Task
    {
        $validationResult = $this->taskValidator->validate($data);

        if ($validationResult->count() > 0) {
            throw new InvalidDataException((string) $validationResult);
        }

        return $this->taskRepository->saveTask($userId, $data['title'], new \DateTime($data['start_date']), $data['description'], $id);
    }

    /**
     * @param $id
     * @throws \DC\Repository\Exception\DbErrorException
     */
    public function removeTask($id)
    {
        $this->taskRepository->deleteTask($id);
    }
}