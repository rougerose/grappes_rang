<?php
if (!defined("_ECRIRE_INC_VERSION")) return;

function action_rang_objets_dist() {
    $securiser_action = charger_fonction('securiser_action', 'inc');
    $arg = $securiser_action();
    list($action,$source,$id_source,$cible,$id_cible,$sens) = explode('/',$arg);

    if ($action == 'changer') {
        if ($sens == 'descendre') {
            // le rang de l'objet à modifier
            $rang = sql_getfetsel('rang', 'spip_grappes_liens', array('id_grappe='.sql_quote($id_source),'objet='.sql_quote($cible),'id_objet='.sql_quote($id_cible)));
            // modifier le rang de l'objet suivant
            sql_updateq('spip_grappes_liens', array('rang' => $rang), array('id_grappe='.sql_quote($id_source),'objet='.sql_quote($cible),'rang='.sql_quote($rang+1)));
            // modifier le rang de l'objet ciblé
            sql_updateq('spip_grappes_liens', array('rang' => ++$rang), array('id_grappe='.sql_quote($id_source),'objet='.sql_quote($cible),'id_objet='.sql_quote($id_cible)));
        }
        if ($sens == 'monter') {
            // le rang de l'objet à modifier
            $rang = sql_getfetsel('rang', 'spip_grappes_liens', array('id_grappe='.sql_quote($id_source),'objet='.sql_quote($cible),'id_objet='.sql_quote($id_cible)));
            // modifier le rang de l'objet précédent
            sql_updateq('spip_grappes_liens', array('rang' => $rang), array('id_grappe='.sql_quote($id_source),'objet='.sql_quote($cible),'rang='.sql_quote($rang-1)));
            // modifier le rang de l'objet ciblé
            sql_updateq('spip_grappes_liens', array('rang' => --$rang), array('id_grappe='.sql_quote($id_source),'objet='.sql_quote($cible),'id_objet='.sql_quote($id_cible)));
        }
    }
}

?>