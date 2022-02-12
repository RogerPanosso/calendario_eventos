//define codigo js executando biblioteca fullCalendar após execução da página
document.addEventListener('DOMContentLoaded', function () {

	//seleciona elemento html com id(calendar)
    let idCalendar = document.querySelector("#calendar");

    //instancia(objeto) da class FullCalendar executando método Calendar
    let calendar = new FullCalendar.Calendar(idCalendar, {
        locale: 'pt-br',
        plugins: ['interaction', 'dayGrid'],
        editable: true,
        eventLimit: true,
        events: 'select_eventos.php',
        extraParams: function () {
            return {
                cachebuster: new Date().valueOf()
            };
        },
        eventClick: function(info) {
           //previne carregamento da página
           info.jsEvent.preventDefault();

           //cria ids armazenando valores e apresentando dentro do modal
           $("body").find("#visualizarEvento #id").text(info.event.id);
           $("body").find("#visualizarEvento #title").text(info.event.title);
           $("body").find("#visualizarEvento #start").text(info.event.start.toLocaleString());
           $("body").find("#visualizarEvento #end").text(info.event.end.toLocaleString());
           
           //repeti procedimento com ação .val() para atribuir valores aos inputs de form de edição
           $("body").find("#visualizarEvento #id").val(info.event.id);
           $("body").find("#visualizarEvento #title").val(info.event.title);
           $("body").find("#visualizarEvento #color").val(info.event.backgroundColor);
           $("body").find("#visualizarEvento #start").val(info.event.start.toLocaleString());
           $("body").find("#visualizarEvento #end").val(info.event.end.toLocaleString());
           
           //seleciona link de deletar evento atribuindo id responsável para exclusão
           $("body").find("#deleteEvento").attr("data-id", info.event.id);
           
           //apresenta modal visualizarEvento 
           $("body").find("#visualizarEvento").modal("show");
        },
        initialView: "dayGridMonth",
        selectable: true,
        select: function(info) {
          $("body").find("#cadastrarEvento #start").val(info.start.toLocaleString());
          $("body").find("#cadastrarEvento #end").val(info.end.toLocaleString());
          $("body").find("#cadastrarEvento").modal("show");
        }
    });

    //executa sobre objeto calendar método render() executando calendario em elemento html(id calendar)
    calendar.render();

});

//define codigo jQuery selecionando form de cadastro de evento
$(document).ready(function(){
  $("body").find("#form_cad").on("submit", function(event){
    event.preventDefault();
    let form = document.querySelector("#form_cad");
    let formName = document.querySelector("#form_cad").name;
    if($.type(form) != "object" || $.type(formName) != "string") {
      $("body").find("#result_cad").fadeIn().html("<span>*Tipos de dados invalidos</span>");
      setTimeout(function(){
        $("body").find("#result_cad").fadeOut();
      }, 5000);
      return false;
    }
    let title = $(this).find("#title").val().trim();
    let color = $(this).find("#color").val().trim();
    let start = $(this).find("#start").val().trim();
    let end = $(this).find("#end").val().trim();
    if(title == "" || color == "" || start == "" || end == "") {
      $("body").find("#result_cad").fadeIn().html("<span class='text-danger'>*Todos os campos são obrigatórios</span>");
      $("body").find("#result_cad").css("transition", "all ease .1s");
      setTimeout(function(){
        $("body").find("#result_cad").fadeOut();
      }, 5000);
      return false;
    }else {
      //requisição interna ajax
      $.ajax({
        type:"POST",
        url:"insert_evento.php",
        dataType:"json",
        data:{
          title:title,
          color:color,
          start:start,
          end:end
        },
        success:function(json) {
          /*
          if($.type(json) == "object") {
            if(json.return == "success") {
              $("body").find("#result_cad").fadeIn().html("<span class='text-success'>Evento Cadastrado com sucesso. Id do evento: "+json.idEvento+"</span>");
            }else if(json.return == "error") {
              $("body").find("#result_cad").fadeIn().html("<span class='text-danger'>Falha ao realizar cadastro de evento</span>");
            }else if(json.return == "exist") {
              $("body").find("#result_cad").fadeIn().html("<span class='text-danger'>Evento com título já cadastrado</span>");
            }
            setTimeout(function(){
              $("body").find("#result_cad").fadeOut();
              setTimeout(function(){
                window.location.reload();
              }, 2000);
            }, 5000);
          }
          */
          console.log(json);
        },
        error:function(response) {
          console.log(response);
          return false;
        }
      });
    }
  });
  
  //define codigo jQuery carregando form de edição 
  $(document).ready(function(){
    $("body").find(".ocultVisualizacao").on("click", function(){
      $(".visualizacaoEvento").slideToggle();
      $(".editarEvento").slideToggle();
    });  
  });
  
  //define codigo jQuery cancelando form de edição e retorando visualização
  $(document).ready(function(){
     $("body").find(".cancelarEdicao").on("click", function(){
         $("body").find(".editarEvento").slideToggle();
         $("body").find(".visualizacaoEvento").slideToggle();
     });
  });
  
  //seleciona form de edição de evento
  $("body").find("#form_edit").on("submit", function(event){
     event.preventDefault();
     let form = document.querySelector("#form_edit");
     let formName = document.querySelector("#form_edit").name;
     if($.type(form) != "object" || $.type(formName) != "string") {
        $("body").find("#result_edit").fadeIn().html("<span>*Tipos de dados invalidos</span>");
        setTimeout(function(){
            $("body").find("#result_edit").fadeOut();
        }, 5000);
        return false;
     }
     let id = parseInt($(this).find("#id").val());
     let title = $(this).find("#title").val().trim();
     let color = $(this).find("#color").val().trim();
     let start = $(this).find("#start").val().trim();
     let end = $(this).find("#end").val().trim();
     $.ajax({
         type:"POST",
         url:"update_evento.php",
         dataType:"json",
         data:{
            id:id,
            title:title,
            color:color,
            start:start,
            end:end
         },
         success:function(json) {
            if($.type(json) == "object" && json != "") {
                if(json.return == "success") {
                    $("body").find("#result_edit").fadeIn().html("<span class='text-success'>Evento editado com sucesso</span>");
                }else {
                    $("body").find("#result_edit").fadeIn().html("<span class='text-danger'>Falha ao editar evento</span>");
                }
                $("body").find("#result_edit").css("transition", "all ease .1s");
                setTimeout(function(){
                   $("body").find("#result_edit").fadeOut();
                   setTimeout(function(){
                      window.location.reload();
                   }, 2000);
                }, 5000);
            }
         },
         error:function(response) {
            console.log(response);
            return false;
         }
     });
  });  
  
  $(document).on("click", "#deleteEvento", function(){
        let id = $(this).attr("data-id");
        $.ajax({
            type:"POST",
            url:"delete_evento.php",
            dataType:"json",
            data:{id:id},
            success:function(json) {
                if($.type(json) == "object") {
                    if(json.return == "success") {
                        $("body").find("#result_delete").fadeIn().html("<span class='text-danger'>Evento excluido com sucesso</span>");
                    }else {
                        $("body").find("#result_delete").fadeIn().html("<span class='text-danger'>Falha ao excluir evento</span>");
                    }
                    $("body").find("#result_delete").css("transition", "all ease .1s");
                    setTimeout(function(){
                      $("body").find("#result_delete").fadeOut();
                      setTimeout(function(){
                        window.location.reload();
                      }, 2000);
                    }, 5000);
                }
            },
            error:function(response) {
                console.log(response);
                return false;
            }
        });
  });
});

