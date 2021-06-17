<?php

namespace DC\Tests\Unit\Service\Task;

use DC\Entity\Task;
use DC\Repository\TaskRepository;
use DC\Service\Task\Exception\InvalidDataException;
use DC\Service\Task\TaskService;
use DC\Service\Task\Validator\TaskValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class TaskServiceTest extends TestCase
{
    // tests get tasks
    public function testGetUserDailyTasks()
    {
        $repo = $this->createMock(TaskRepository::class);
        $repo->expects($this->once())
            ->method('findUserTasksBetweenDates')
            ->willReturn(['data']);

        $valiator = $this->createMock(TaskValidator::class);

        $taskService = new TaskService($repo, $valiator);

        $this->assertEquals(['data'], $taskService->getUserDailyTasks(1));
    }

    // tests create task
    public function testCreateTask()
    {
        $task = new Task();
        $task->setTitle('test');
        $task->setDescription('test');
        $task->setUserId(1);

        $repo = $this->createMock(TaskRepository::class);
        $repo->expects($this->once())
            ->method('saveTask')
            ->willReturn($task);

        $constrain = $this->createMock(ConstraintViolationListInterface::class);
        $constrain
            ->expects($this->once())
            ->method('count')
            ->willReturn(0);

        $valiator = $this->createMock(TaskValidator::class);
        $valiator
            ->expects($this->once())
            ->method('validate')
            ->willReturn($constrain);

        $taskService = new TaskService($repo, $valiator);
        $taskService->createTask(1, ['title' => 'test', 'description' => 'test', 'start_date' => '2021-06-17']);

        $this->assertTrue(true);
    }

    public function testCreateTaskInvalidData()
    {
        $task = new Task();
        $task->setTitle('test');
        $task->setDescription('test');
        $task->setUserId(1);

        $repo = $this->createMock(TaskRepository::class);

        $constrain = $this->createMock(ConstraintViolationList::class);
        $constrain
            ->expects($this->once())
            ->method('count')
            ->willReturn(1);
        $constrain
            ->expects($this->once())
            ->method('__toString')
            ->willReturn('Errrooooor');

        $valiator = $this->createMock(TaskValidator::class);
        $valiator
            ->expects($this->once())
            ->method('validate')
            ->willReturn($constrain);

        $taskService = new TaskService($repo, $valiator);

        $this->expectException(InvalidDataException::class);

        $taskService->createTask(1, []);
    }

    // tests update task
    // tests create task
    public function testUpdateTask()
    {
        $task = new Task();
        $task->setTitle('test');
        $task->setDescription('test');
        $task->setUserId(1);

        $repo = $this->createMock(TaskRepository::class);
        $repo->expects($this->once())
            ->method('saveTask')
            ->willReturn($task);

        $constrain = $this->createMock(ConstraintViolationListInterface::class);
        $constrain
            ->expects($this->once())
            ->method('count')
            ->willReturn(0);

        $valiator = $this->createMock(TaskValidator::class);
        $valiator
            ->expects($this->once())
            ->method('validate')
            ->willReturn($constrain);

        $taskService = new TaskService($repo, $valiator);
        $taskService->updateTask(1,1, ['title' => 'test', 'description' => 'test', 'start_date' => '2021-06-17']);

        $this->assertTrue(true);
    }

    public function testUpdateTaskInvalidData()
    {
        $task = new Task();
        $task->setTitle('test');
        $task->setDescription('test');
        $task->setUserId(1);

        $repo = $this->createMock(TaskRepository::class);

        $constrain = $this->createMock(ConstraintViolationList::class);
        $constrain
            ->expects($this->once())
            ->method('count')
            ->willReturn(1);
        $constrain
            ->expects($this->once())
            ->method('__toString')
            ->willReturn('Errrooooor');

        $valiator = $this->createMock(TaskValidator::class);
        $valiator
            ->expects($this->once())
            ->method('validate')
            ->willReturn($constrain);

        $taskService = new TaskService($repo, $valiator);

        $this->expectException(InvalidDataException::class);

        $taskService->updateTask(1,1, []);
    }

    // tests delete task
    public function testDeleteTask()
    {
        $task = new Task();
        $task->setTitle('test');
        $task->setDescription('test');
        $task->setUserId(1);

        $repo = $this->createMock(TaskRepository::class);
        $repo
            ->expects($this->once())
            ->method('deleteTask')
            ->with(1);

        $valiator = $this->createMock(TaskValidator::class);

        $taskService = new TaskService($repo, $valiator);
        $taskService->removeTask(1);
        $this->assertTrue(true);
    }
}