<?php

namespace DC\Fixtures;

use DC\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TaskFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $titles = [
            'Apply These 9 Secret Techniques To Improve My Task For Tomorrow',
            'Believing These 9 Myths About My Task For Tomorrow Keeps You From Growing',
            'Don\'t Waste Time! 9 Facts Until You Reach Your My Task For Tomorrow',
            'How 9 Things Will Change The Way You Approach My Task For Tomorrow',
            'My Task For Tomorrow Awards: 9 Reasons Why They Don\'t Work & What You Can Do About It',
            'My Task For Tomorrow Doesn\'t Have To Be Hard. Read These 9 Tips',
            'My Task For Tomorrow Is Your Worst Enemy. 9 Ways To Defeat It',
            'My Task For Tomorrow On A Budget: 9 Tips From The Great Depression',
            'Knowing These 9 Secrets Will Make Your My Task For Tomorrow Look Amazing',
            'Master The Art Of My Task For Tomorrow With These 9 Tips',
            'My Life, My Job, My Career: How 9 Simple My Task For Tomorrow Helped Me Succeed',
            'Take Advantage Of My Task For Tomorrow - Read These 9 Tips',
            'The Next 9 Things You Should Do For My Task For Tomorrow Success',
            'The Time Is Running Out! Think About These 9 Ways To Change Your My Task For Tomorrow',
            'The 9 Best Things About My Task For Tomorrow',
            'The 9 Biggest My Task For Tomorrow Mistakes You Can Easily Avoid'
        ];

        $description = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque at bibendum lectus. Maecenas nec molestie nunc. Nulla condimentum luctus massa ac dapibus. Etiam auctor et velit a pretium. Proin maximus, lacus vel placerat tincidunt, metus nunc ornare ante, in finibus nulla dui a leo. Nunc vitae urna non purus varius dictum. Curabitur vitae ipsum sit amet enim pulvinar laoreet. Aenean sem eros, pellentesque commodo magna quis, sagittis placerat lorem. Sed tempus diam ut tristique laoreet. Vestibulum dapibus sit amet magna quis iaculis. Nulla est nisl, pellentesque sed euismod id, mattis id erat. Curabitur sed magna blandit, cursus libero non, ultricies arcu.

Sed interdum porttitor velit. Aliquam non lectus ante. Morbi eu lorem sit amet augue sodales viverra quis id ante. Cras eget justo eget metus varius tempor in at nisl. Nam ultricies lacus ac lacinia efficitur. Nulla facilisi. Praesent at odio rutrum, condimentum ex ac, porta neque. Morbi tempor maximus est, ut hendrerit augue commodo quis. Morbi nisl purus, ultrices lobortis nibh id, feugiat blandit nisl. Fusce dictum mi eu nunc fermentum commodo. Cras dolor elit, euismod dictum ligula sed, tincidunt varius velit. Mauris aliquam ornare magna mollis laoreet.

In condimentum pulvinar tincidunt. Sed volutpat facilisis tellus vel auctor. Sed quam libero, ultrices id enim at, laoreet elementum justo. Nullam egestas diam in faucibus placerat. Pellentesque auctor convallis lorem, a blandit leo rutrum in. Sed fermentum tincidunt tempus. Aliquam tristique a sem sit amet finibus. Phasellus bibendum molestie metus quis hendrerit. Vestibulum lacinia rutrum purus volutpat tempor.';
        // $product = new Product();
        // $manager->persist($product);
        $now = new \DateTime();
        foreach ($titles as $title) {
            $task = new Task();
            $task->setDescription($description);
            $task->setTitle($title);
            $task->setStartDate($now);
            $task->setCreatedAt($now);
            $task->setUpdatedAt($now);
            $task->setUserId(1);

            $manager->persist($task);
        }

        $manager->flush();
    }
}
