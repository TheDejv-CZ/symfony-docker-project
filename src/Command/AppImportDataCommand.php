<?php
namespace App\Command;

use App\Entity\User;
use App\Entity\Post;
use App\Entity\Comment;
use App\Entity\UserInfo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;

class AppImportDataCommand extends Command
{
    
    private EntityManagerInterface $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }
    
    protected function configure(): void
    {
        $this->setName('app:import-data');
        $this->setDescription('Import data from JSONPlaceholder API.');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output) :int
    {
        $client = HttpClient::create();
        
        $response = $client->request('GET', 'https://jsonplaceholder.typicode.com/users');
        $users = $response->toArray();
        $userEntities = [];
        foreach ($users as $userData) {
            $user = new User();
            $user->setName($userData['name']);
            $user->setUsername($userData['username']);
            $user->setEmail($userData['email']);
            $user->setPhone($userData['phone']);
            $user->setWebsite($userData['website']);
            $this->entityManager->persist($user);
            
            $userInfo = new UserInfo();
            $userInfo->setUser($user);
            $userInfo->setStreet($userData['address']['street']);
            $userInfo->setSuite($userData['address']['suite']);
            $userInfo->setCity($userData['address']['city']);
            $userInfo->setZipCode($userData['address']['zipcode']);
            $userInfo->setSLat($userData['address']['geo']['lat']);
            $userInfo->setSLng($userData['address']['geo']['lng']);
            
            $userInfo->setCompanyName($userData['company']['name']);
            $userInfo->setCompanyCatchPhrase($userData['company']['catchPhrase']);
            $userInfo->setCompanyBs($userData['company']['bs']);
            $this->entityManager->persist($userInfo);
            
            $userEntities[$userData['id']] = $user;
        }
        $this->entityManager->flush();
        
        $response = $client->request('GET', 'https://jsonplaceholder.typicode.com/posts');
        $posts = $response->toArray();
        $postEntities = [];
        foreach ($posts as $postData) {
            $post = new Post();
            $post->setUser($userEntities[$postData['userId']]);
            $post->setTitle($postData['title']);
            $post->setBody($postData['body']);
            $this->entityManager->persist($post);
            $postEntities[$postData['id']] = $post;
        }
        $this->entityManager->flush();
        
        $response = $client->request('GET', 'https://jsonplaceholder.typicode.com/comments');
        $comments = $response->toArray();
        foreach ($comments as $commentData) {
            $comment = new Comment();
            $comment->setPost($postEntities[$commentData['postId']]);
            $comment->setName($commentData['name']);
            $comment->setEmail($commentData['email']);
            $comment->setBody($commentData['body']);
            $this->entityManager->persist($comment);
        }
        $this->entityManager->flush();
        
        return Command::SUCCESS;
    }
}