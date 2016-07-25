/**
 * JQuery Shopping List ( http://tuts.guillaumevoisin.fr/jquery/shoppingList/ ) 
 * Copyright (c) Guillaume Voisin 2010
 */
 
(function($){
	$.fn.shoppingList = function(options) {

		// Options par defaut
		var defaults = {
		};
				
		var options = $.extend(defaults, options);
		
		this.each(function(){
				
			var obj = $(this);
			
			// Emp�cher la s�lection des �l�ments � la sourirs (meilleure gestion du drag & drop)
			var _preventDefault = function(evt) { evt.preventDefault(); };
			$("li").bind("dragstart", _preventDefault).bind("selectstart", _preventDefault);

			// Initialisation du composant "sortable"
			$(obj).sortable({
				axis: "y", // Le sortable ne s'applique que sur l'axe vertical
				containment: ".shoppingList", // Le drag ne peut sortir de l'�l�ment qui contient la liste
				handle: ".item", // Le drag ne peut se faire que sur l'�l�ment .item (le texte)
				distance: 10, // Le drag ne commence qu'� partir de 10px de distance de l'�l�ment
				// Evenement appel� lorsque l'�l�ment est relach�
				stop: function(event, ui){
					// Pour chaque item de liste
					$(obj).find("li").each(function(){
						// On actualise sa position
						index = parseInt($(this).index()+1);
						// On la met � jour dans la page
						$(this).find(".count").text(index);
					});
				}
			});
			
			// On ajoute l'�l�ment Poubelle � notre liste
			$(obj).after("<div class='trash'>Trash</div>");
			// On ajoute un petit formulaire pour ajouter des items
			$(obj).after("<div class='add'><input class='addValue' /> <input type='button' value='Add' class='addBtn' /></div>");
					
			// Action de la poubelle
			// Initialisation du composant Droppable
			$(".trash").droppable({
				// Lorsque l'on relache un �l�ment sur la poubelle
				drop: function(event, ui){
					// On retire la classe "hover" associ�e au div .trash
					$(this).removeClass("hover");
					// On ajoute la classe "deleted" au div .trash pour signifier que l'�l�ment a bien �t� supprim�
					$(this).addClass("deleted");
					// On affiche un petit message "Cet �l�ment a �t� supprim�" en r�cup�rant la valeur textuelle de l'�l�ment relach�
					$(this).text(ui.draggable.find(".item").text()+" removed !");
					// On supprimer l'�l�ment de la page, le setTimeout est un fix pour IE (http://dev.jqueryui.com/ticket/4088)
					setTimeout(function() { ui.draggable.remove(); }, 1);
					
					// On retourne � l'�tat originel de la poubelle apr�s 2000 ms soit 2 secondes
					elt = $(this);
					setTimeout(function(){ elt.removeClass("deleted"); elt.text("Trash"); }, 2000);
				},
				// Lorsque l'on passe un �l�ment au dessus de la poubelle
				over: function(event, ui){
					// On ajoute la classe "hover" au div .trash
					$(this).addClass("hover");
					// On cache l'�l�ment d�plac�
					ui.draggable.hide();
					// On indique via un petit message si l'on veut bien supprimer cet �l�ment
					$(this).text("Remove "+ui.draggable.find(".item").text());
					// On change le curseur
					$(this).css("cursor", "pointer");
				},
				// Lorsque l'on quitte la poubelle
				out: function(event, ui){
					// On retire la classe "hover" au div .trash
					$(this).removeClass("hover");
					// On r�affiche l'�l�ment d�plac�
					ui.draggable.show();
					// On remet le texte par d�faut
					$(this).text("Trash");
					// Ainsi que le curseur par d�faut
					$(this).css("cursor", "normal");
				}
			})
			
			// Pour chaque �l�ment trouv� dans la liste de d�part
			$(obj).find("li").each(function(){
				// On ajoute les contr�les
				addControls($(this));
			});
			
			/*
			* Ajouter les controles sur le bouton "ajouter"
			*
			* @Return void
			*/
			
			// Bouton ajouter
			$(".addBtn").click(function(){
				// Si le texte n'est pas vide
				if($(".addValue").val() != "")
				{
					// On ajoute un nouvel item � notre liste
					$(obj).append('<li>'+$(".addValue").val()+'</li>');
					// On r�initialise le champ de texte pour l'ajout
					$(".addValue").val("");
					// On ajoute les contr�les � notre nouvel item
					addControls($(obj).find("li:last-child"));
				}
			})
			// On autorise �galement la validation de la saisie d'un nouvel item par pression de la touche entr�e
			$(".addValue").live("keyup", function(e) {
				if(e.keyCode == 13) {
					// On lance l'�v�nement click associ� au bouton d'ajout d'item
					$(".addBtn").trigger("click");
				}
			});
			
			/*
			* Fonction qui ajoute les contr�les aux items
			* @Param�tres
			*  - elt: �l�ment courant (liste courante)
			*
			* @Return void
			*/
			
			function addControls(elt)
			{
				// On ajoute en premier l'�l�ment textuel
				$(elt).html("<span class='item'>"+$(elt).text()+"</item>");
				// Puis l'�l�ment de position
				$(elt).prepend('<span class="count">'+parseInt($(elt).index()+1)+'</span>');
				// Puis l'�l�ment d'action (�l�ment achet�)
				$(elt).prepend('<span class="check unchecked"></span>');
				
				// Au clic sur cet �l�ment
				$(elt).find(".check").click(function(){
					// On alterne la classe de l'item (le <li>), le CSS associ� fera que l'�l�ment sera barr�
					$(this).parent().toggleClass("bought");
					
					// Si cet �l�ment est achet�
					if($(this).parent().hasClass("bought"))
						// On modifie la classe en ajoutant la classe "checked"
						$(this).removeClass("unchecked").addClass("checked");
					// Le cas contraire
					else
						// On modifie la classe en retirant la classe "checked"
						$(this).removeClass("checked").addClass("unchecked");
				})
				
				// Au double clic sur le texte
				$(elt).find(".item").dblclick(function(){
					// On r�cup�re sa valeur
					txt = $(this).text();
					// On ajoute un champ de saisie avec la valeur
					$(this).html("<input value='"+txt+"' />");
					// On la s�lectionne par d�faut
					$(this).find("input").select();
				})
				
				// Lorsque l'on quitte la zone de saisie du texte
				$(elt).find(".item input").live("blur", function(){
					// On r�cup�re la valeur du champ de saisie
					txt = $(this).val();
					// On ins�re dans le <li> la nouvelle valeur textuelle
					$(this).parent().html(txt);
				})
				
				// On autorise la m�me action lorsque l'on valide par la touche entr�e
				$(elt).find(".item input").live("keyup", function(e) {
					if(e.keyCode == 13) {
						$(this).trigger("blur");
					}
				});
			}
		});
		// On continue le chainage JQuery
		return this;
	};
})(jQuery);