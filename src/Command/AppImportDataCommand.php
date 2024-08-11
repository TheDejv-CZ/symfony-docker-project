<?php
namespace App\Command;

use App\Entity\User;
use App\Entity\Post;
use App\Entity\Comment;
use App\Entity\UserInfo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
#[AsCommand(
    name: 'app:import-data',
    description: 'Import data from JSONPlaceholder API.'
)]
class AppImportDataCommand extends Command
{
    
    private EntityManagerInterface $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }
    
    protected function execute(InputInterface $input, OutputInterface $output) :int
    {
        $client = HttpClient::create();
        $userEntities = [];
        $postEntities = [];
        try {
            // import users
            
            $response = $client->request('GET', 'https://jsonplaceholder.typicode.com/users');
            $users = $response->toArray();
            foreach ($users as $userData) {
                $user = (new User())
                    ->setName($userData['name'])
                    ->setUsername($userData['username'])
                    ->setEmail($userData['email'])
                    ->setPhone($userData['phone'])
                    ->setWebsite($userData['website']);
                
                $this->entityManager->persist($user);
                
                $userInfo = (new UserInfo())
                    ->setUser($user)
                    ->setStreet($userData['address']['street'])
                    ->setSuite($userData['address']['suite'])
                    ->setCity($userData['address']['city'])
                    ->setZipCode($userData['address']['zipcode'])
                    ->setSLat($userData['address']['geo']['lat'])
                    ->setSLng($userData['address']['geo']['lng'])
                    ->setCompanyName($userData['company']['name'])
                    ->setCompanyCatchPhrase($userData['company']['catchPhrase'])
                    ->setCompanyBs($userData['company']['bs']);
                
                $this->entityManager->persist($userInfo);
                
                $userEntities[$userData['id']] = $user;
            }
            $this->entityManager->flush();
            
            // import posts
            
            $response = $client->request('GET', 'https://jsonplaceholder.typicode.com/posts');
            $posts = $response->toArray();
            
            foreach ($posts as $postData) {
                $post = (new Post())
                    ->setUser($userEntities[$postData['userId']])
                    ->setTitle($postData['title'])
                    ->setBody($postData['body']);
                
                $this->entityManager->persist($post);
                $postEntities[$postData['id']] = $post;
            }
            $this->entityManager->flush();
            
            // import comments
            
            $response = $client->request('GET', 'https://jsonplaceholder.typicode.com/comments');
            $comments = $response->toArray();
            
            foreach ($comments as $commentData) {
                $comment = (new Comment())
                    ->setPost($postEntities[$commentData['postId']])
                    ->setName($commentData['name'])
                    ->setEmail($commentData['email'])
                    ->setBody($commentData['body']);
                $this->entityManager->persist($comment);
            }
            $this->entityManager->flush();
        } catch (ClientExceptionInterface | RedirectionExceptionInterface | ServerExceptionInterface | TransportExceptionInterface $e) {
            $output->writeln('<error>HTTP request failed: ' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        } catch (\Exception $e) {
            $output->writeln('<error>Data import failed: ' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }
        
        return Command::SUCCESS;
    }
}