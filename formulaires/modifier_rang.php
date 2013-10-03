<?php 
if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_modifier_rang_charger($rang,$source,$id_source,$objet,$id_objet,$identifiant){
    return array(
        'rang' => $rang,
        'source' => $source,
        'id_source' => $id_source,
        'objet' => $objet,
        'id_objet' => $id_objet,
        'identifiant' => $identifiant,
        '_hidden' => "<input type='hidden' name='rang_prev' value='".$rang."' />"
    );
}

function formulaires_modifier_rang_verifier($rang,$source,$id_source,$objet,$id_objet,$identifiant){
    return $erreurs;
}

function formulaires_modifier_rang_traiter($rang,$source,$id_source,$objet,$id_objet,$identifiant){
    $ancien = _request('rang_prev'); 
    $nouveau = _request('rang');
    if ($nouveau !== $ancien) {
        sql_updateq('spip_grappes_liens', array('rang' => $nouveau), "id_grappe=$id_source AND objet='$objet' AND id_objet='$id_objet'");
    }

    return array(true,''); // permettre d'editer encore le formulaire
}
?>