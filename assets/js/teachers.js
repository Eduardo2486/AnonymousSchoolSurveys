$(document).ready(function(){
    function editUser(id, text, field){
        $.ajax({
            method: "POST",
            url: "/cuestionario/core/ajax/update-teacher.php",
            data: { id: id, text: text, field: field }
        })
        .done(function( msg ) {
            if(parseInt(msg) == 1){
                console.log(msg);
                iziToast.success({
                    title: 'OK',
                    message: 'Has changed succesfully to: '+text,
                });
            }
        });
    }
    $(".teacher-nombre, .teacher-apellido-paterno, .teacher-apellido-materno, .teacher-matricula, .teacher-email").keypress(function(e){ 
        
        if(e.which === 13){
            let id = $(this).attr('data-id');
            let field = $(this).attr('data-field');
            let text = $(this).text();
            id = parseInt(id)

            editUser(id, text, field);

            return false;
        }
    });

    function deleteUser(id, enrollment){
        $.ajax({
            method: "POST",
            url: "/cuestionario/core/ajax/delete-teacher.php",
            data: { id: id }
        })
        .done(function( msg ) {
            if(parseInt(msg) == 1){
                
                console.log(msg);
                iziToast.success({
                    title: 'OK',
                    message: 'Has been deleted successfully: '+enrollment,
                });
            }
        });
    }

    $(".delete-record").click(function(e){
        let enrollment = $(this).parent().parent()[0].children[3].innerText;
        let id = $(this).attr('data-id');
        let tr = $(this).parent().parent()[0];
        
        iziToast.question({
            timeout: 20000,
            close: false,
            overlay: true,
            displayMode: 'once',
            id: 'question',
            zindex: 999,
            title: 'Hey',
            message: 'Are you sure you want to delete this:'+enrollment,
            position: 'center',
            buttons: [
                ['<button><b>YES</b></button>', function (instance, toast) {
         
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    deleteUser(id,enrollment);
                    
                    tr.style.display="none";
                }, true],
                ['<button>NO</button>', function (instance, toast) {
         
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                   
                }],
            ],
            onClosing: function(instance, toast, closedBy){
                console.info('Closing | closedBy: ' + closedBy);
            },
            onClosed: function(instance, toast, closedBy){
                console.info('Closed | closedBy: ' + closedBy);
            }
        });
    });
    $(".erase-fields").click(function(e){
        $(".name-input").val("");
        $(".flastname-input").val("");
        $(".slastname-input").val("");
        $(".enrollment-input").val("");
        $(".email-input").val("");
    });
});