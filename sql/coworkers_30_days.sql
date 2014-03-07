-- Query to know the coworkers who used at least 1 ticket during the 30 last days
select distinct CONCAT(meta.first_name,' ',meta.last_name), sum(ticket_log.nb_ticket)
from ticket_log
inner join commandes on ticket_log.commande_id = commandes.id
inner join meta on commandes.user_id = meta.user_id
where ticket_log.`date` > DATE_ADD(NOW(),INTERVAL -30 DAY)
group by meta.user_id;
