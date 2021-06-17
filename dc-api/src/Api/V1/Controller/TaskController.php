<?php

namespace DC\Api\V1\Controller;

use DC\Service\Task\TaskService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends ApiBaseController
{
    /**
     * @var TaskService
     */
    protected $taskService;

    /**
     * TaskController constructor.
     * @param TaskService $taskService
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * @Route("/task/my-list", name="api_task_daily", methods={"GET"})
     */
    public function getMyTaskList()
    {
        $tasks = $this->taskService->getUserDailyTasks($this->getUser()->getUserIdentifier());

        return $this->response($tasks);
    }

    /**
     * @Route("/task", name="api_create_task", methods={"POST"})
     */
    public function createTask(Request $request)
    {

        $task = $this->taskService->createTask($this->getUser()->getUserIdentifier(), $request->request->all());

        return $this->response($task);
    }

    /**
     * @Route("/task/{id}", name="api_update_task", methods={"PUT"})
     */
    public function updateTask(int $id, Request $request)
    {
        $task = $this->taskService->updateTask($id, $this->getUser()->getUserIdentifier(), $request->request->all());

        return $this->response($task);
    }

    /**
     * @Route("/task/{id}", name="api_delete_task", methods={"DELETE"})
     */
    public function deleteTask(int $id)
    {
        $this->taskService->removeTask($id);

        return $this->response('');
    }
}