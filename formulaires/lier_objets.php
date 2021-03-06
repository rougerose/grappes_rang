<?php

/**
 * Plugin Groupes pour Spip 2.0
 * Licence GPL (c) 2008 Matthieu Marcillaud
 */

if (!defined("_ECRIRE_INC_VERSION")) return;

// chargement des valeurs par defaut des champs du formulaire
/**
 *
 * @param string $objet (Le type d'objet à trouver)
 * @param unknown_type $source
 * @param unknown_type $id_source
 * @param unknown_type $identifiant
 */
function formulaires_lier_objets_charger($objet, $source, $id_source, $identifiant){
	return
		array(
			'objet' => $objet,
			'source' => $source,
			'id_source' => $id_source,
			id_table_objet($source) => $id_source,
			'identifiant' => $identifiant
			//'editable' => autoriser('associer',objet_type($source),$id_source,null,array('cible'=>$objet))
		);
}

function formulaires_lier_objets_verifier($objet, $source, $id_source, $identifiant){
	// si pas d'id, le selecteur generique n'a pas fonctionne
	// on fait comment alors ??
	if (!_request('pid_objet')) {
		$erreurs['message_erreur'] = _T('grappes:pas_de_identifiant');
	}

	return $erreurs;
}

function formulaires_lier_objets_traiter($objet, $source, $id_source, $identifiant){
	$id_objet = _request('pid_objet');
	include_spip('action/lier_objets');
	lier_objets($source,$id_source,objet_type($objet),$id_objet);

	// insertion d'une valeur pour le rang
	$obj = objet_type($objet);
	$total = sql_countsel("spip_grappes_liens", array("id_grappe=$id_source", "objet=".sql_quote($obj)));
	if ($total AND $total > 0) {
		sql_updateq('spip_grappes_liens', array('rang' => $total), "id_grappe=$id_source AND objet='$obj' AND id_objet='$id_objet'");
	}

	return array(true,''); // permettre d'editer encore le formulaire
}

?>
