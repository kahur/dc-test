<?php

namespace DC\Api\V1\Controller;

use Symfony\Component\Routing\Annotation\Route;

class TaskController extends ApiBaseController
{
    /**
     * @Route("/task", name="api_task_test", methods={"GET"})
     */
    public function test()
    {
        return $this->response('ok');
    }
    /**
     * @Route("/task/{id}", name="api_task_one", methods={"GET"})
     */
    public function getTask()
    {
        return $this->json(['task']);
    }

    /**
     * @Route("/task/my-list", name="api_task_all", methods={"GET"})
     */
    public function getMyTaskList()
    {
        return $this->json(['tasks']);
    }

    /**
     * @Route("/task", name="api_create_task", methods={"POST"})
     */
    public function createTask()
    {
        return $this->json(['task']);
    }

    /**
     * @Route("/task", name="api_update_task", methods={"PUT"})
     */
    public function updateTask()
    {
        return $this->json(['task']);
    }

    /**
     * @Route("/task/{id}", name="api_delete_task", methods={"DELETE"})
     */
    public function deleteTask()
    {
        return $this->json(['task']);
    }
}