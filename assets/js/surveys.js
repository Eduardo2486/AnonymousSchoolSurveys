$(document).ready(function(){
    function editUser(id, text, field){
        
        $.ajax({
            method: "POST",
            url: "/cuestionario/core/ajax/update-survey.php",
            data: { id: id, text: text, field: field }
        })
        .done(function( msg ) {
            
            console.log(msg);
            if(parseInt(msg) == 1){
                iziToast.success({
                    title: 'OK',
                    message: 'Has changed succesfully to: '+text,
                });
            }else{
                iziToast.error({
                    title: 'Error',
                    message: 'It as not been changed, Try again later.',
                });
            }
        });
    }
    $(".title, .comment").keypress(function(e){ 
        
        if(e.which === 13){
            let id = $(this).attr('data-id');
            let field = $(this).attr('data-field');
            let text = $(this).text();

            id = parseInt(id)
            console.log(id, text,field);
            editUser(id, text, field);


            return false;
        }
    });



    function deleteUser(id, enrollment){
        console.log(id, enrollment);
        $.ajax({
            method: "POST",
            url: "/cuestionario/core/ajax/delete-survey.php",
            data: { id: id }
        })
        .done(function( msg ) {
            if(parseInt(msg) == 1){
                
                iziToast.success({
                    title: 'OK',
                    message: 'Has been deleted successfully: '+enrollment,
                });
            }else{
                iziToast.error({
                    title: 'Error',
                    message: 'It as not been deleted, Try again later.',
                });
            }
        });
    }

    $(".delete-record-icon").click(function(e){
        let enrollment = $(this).parent().parent()[0].children[0].innerText;
        let id = $(this).attr('data-id');
        let tr = $(this).parent().parent()[0];
        console.log(id,tr);
        iziToast.question({
            timeout: 20000,
            close: false,
            overlay: true,
            displayMode: 'once',
            id: 'question',
            zindex: 999,
            title: 'Hey',
            message: 'Are you sure you want to delete this: '+enrollment,
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
        $(".titulo-input").val("");
        $(".comment-input").val("");
        iziToast.success({
            title: 'OK',
            message: 'All fields are clean now.',
        });
    });
});