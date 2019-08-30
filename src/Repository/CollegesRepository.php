<?php

namespace App\Repository;

use App\Entity\Colleges;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Colleges|null find($id, $lockMode = null, $lockVersion = null)
 * @method Colleges|null findOneBy(array $criteria, array $orderBy = null)
 * @method Colleges[]    findAll()
 * @method Colleges[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CollegesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Colleges::class);
    }
}
