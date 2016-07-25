<?php

require_once(dirname(__FILE__) . '/../../../config/config.inc.php');
require_once(dirname(__FILE__) . '/../../../init.php');
require_once(dirname(__FILE__) . '/../ProductCommentCriterion.php');
include_once(dirname(__FILE__) . '/../ProductComment.php');
include_once(dirname(__FILE__) . '/../productcomments.php');

$xml = simplexml_load_file('import.xml');

foreach ($xml->children() as $avis) {
    $comment = new ProductComment();
    $comment->id_product = $avis->produit->ref_produit->__toString();
    $comment->id_customer = 0;
    $comment->id_guest = 0;
    $comment->customer_name = $avis->membre->prenom->__toString()." ".substr($avis->membre->nom->__toString(), 0, 1);
    $comment->title = $avis->avis->titre->__toString();
    $comment->content = $avis->avis->commentaire->__toString();
    $comment->grade = (int)$avis->avis->note_global->__toString();
    $comment->validate = 1;

    $comment->save();
    $comment->date_add = $avis->avis->date->__toString();
    $comment->update();

    $productCommentCriterion = new ProductCommentCriterion(1);
    if ($productCommentCriterion->id)
        $productCommentCriterion->addGrade($comment->id, $comment->grade);
}
?>