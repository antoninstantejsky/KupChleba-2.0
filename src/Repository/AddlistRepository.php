<?php

namespace App\Repository;

use App\Entity\Addlist;
use App\Entity\Shoplist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Addlist>
 *
 * @method Addlist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Addlist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Addlist[]    findAll()
 * @method Addlist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddlistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Addlist::class);
    }
    public function boughtItem(int $itemId): void
    {
        $em = $this->getEntityManager();
        $item = $em->getRepository(Addlist::class)->find($itemId);

        if (!$item) {
            throw $this->createNotFoundException(
                'žádná položka s id'.$itemId
            );
        }

        $item->setBought(1);
        $em->persist($item);
        $em->flush();
    }
    //    /**
    //     * @return Addlist[] Returns an array of Addlist objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Addlist
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
