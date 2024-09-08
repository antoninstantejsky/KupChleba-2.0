<?php

namespace App\Repository;

use App\Entity\Shoplist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Shoplist>
 *
 * @method Shoplist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Shoplist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Shoplist[]    findAll()
 * @method Shoplist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShoplistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shoplist::class);
    }

    public function boughtItem(int $itemId): void
    {
        $em = $this->getEntityManager();
        $item = $em->getRepository(Shoplist::class)->find($itemId);

        if (!$item) {
            throw $this->createNotFoundException(
                'žádná položka s id'.$itemId
            );
        }

        $item->setisDeleted(1);
        $em->persist($item);
        $em->flush();
    }

    //    /**
    //     * @return Shoplist[] Returns an array of Shoplist objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Shoplist
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
