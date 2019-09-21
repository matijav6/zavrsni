<?php

namespace App\Repository;

use App\Entity\Courses;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function saveUser(User $user)
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();;
        return $user;
    }

    public function getPostsForUser(User $user, string $type)
    {
        $userId = $user->getId();
        $sql = "SELECT 
                    p.data as post_data, 
                    courses.aka as course_aka, 
                    courses.name as course_name, 
                    u.first_name as user_name,
                    u.last_name as user_lastname,
                    p.date_updated as date_updated,
                    p.id as post_id,
                    pld.likes  as post_likes,
                    pld.dislikes as post_dislikes
                from courses
                join user_courses uc on courses.id = uc.courses_id
                join user u on uc.user_id = u.id
                join posts p on courses.id = p.course_id
                left join posts_likes_dislikes pld on p.id = pld.post_id
                join post_types pt on p.type_id = pt.id
                where u.id = $userId and pt.name = '$type'
                ORDER BY date_updated DESC";
        $conn = $this->getEntityManager()
            ->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();

        return $results;

    }
}
