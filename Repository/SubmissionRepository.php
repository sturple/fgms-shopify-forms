<?php

namespace Fgms\EmailInquiriesBundle\Repository;

class SubmissionRepository extends \Doctrine\ORM\EntityRepository
{
	/**
	 * Gets all the Submission entities associated
	 * with a Form entity ordered by the date they
	 * were created.
	 *
	 * @param Form $form
	 * @param bool $asc
	 *  True for ascending order (i.e. earliest first),
	 *  false for descending order (i.e. latest first),
	 *  defaults to false.
	 *
	 * @return Traversable|array
	 */
	public function getOrderedByDate(\Fgms\EmailInquiriesBundle\Entity\Form $form, $asc = false)
	{
		$qb = $this->createQueryBuilder('s');
		$qb->innerJoin('s.form','f')
			->andWhere($qb->expr()->eq('f.id',':fid'))
			->setParameter('fid',$form->getId())
			->orderBy('s.created',$asc ? 'ASC' : 'DESC');
		$q = $qb->getQuery();
		//	Not sure why one element arrays are generated...
		//
		//	http://stackoverflow.com/a/15026470/1007504
		foreach ($q->iterate() as $arr) yield $arr[0];
	}
}
