<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Commande {
	
	public var $id;
	public var $adherent_id="";
	public var $pack_id;
	public var $pack_libelle="";
	public var $periode_id;
	public var $periode_libelle="";
	public var $data_achat="";
	public var $nb_ticket=0;
	public var $nb_ticket_utilise=0;
	public var $solde_ticket=0;
	
    function __contruct($p_id,$p_adherent_id,$p_pack_id,$p_pack_libelle,$p_periode_id,$p_periode_libelle,$p_data_achat,$p_nb_ticket,$p_nb_ticket_utilise,$p_solde_ticket)
    {
		$this->id=$p_id;
		$this->adherent_id=$p_adherent_id;
		$this->pack_id=$p_pack_id;
		$this->pack_libelle=$p_pack_libelle;
		$this->periode_id=$p_periode_id;
		$this->periode_libelle=$p_periode_libelle;
		$this->data_achat=$p_data_achat;
		$this->nb_ticket=$p_nb_ticket;
		$this->nb_ticket_utilise=$p_nb_ticket_utilise;
		$this->solde_ticket=$p_solde_ticket;
		
    }
	
?>