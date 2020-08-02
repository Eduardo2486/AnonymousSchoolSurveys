$(document).ready(function(){
    function editUser(id, text, field){
        
        $.ajax({
            method: "POST",
            url: "/cuestionario/core/ajax/update-test.php",
            data: { id: id, text: text, field: field }
        })
        .done(function( msg ) {
            
            console.log(msg);
            if(parseInt(msg) == 1){
                iziToast.success({
                    title: 'OK',
                    message: 'Has changed succesfully to: '+text,
                });
            }else if(msg=='exists'){
                iziToast.error({
                    title: 'Error',
                    message: 'Code already in use.',
                });
            }else{
                iziToast.error({
                    title: 'Error',
                    message: 'It as not been deleted, Try again later',
                });
            }
        });
    }
    $(".questionnaires_total, .code").keypress(function(e){ 
        
        if(e.which === 13){
            let id = $(this).attr('data-id');
            let field = $(this).attr('data-field');
            let text = $(this).val();
            id = parseInt(id)
            editUser(id, text, field);

            return false;
        }
    });


    function deleteUser(id, questionnaire,teacher,subject){
        $.ajax({
            method: "POST",
            url: "/cuestionario/core/ajax/delete-test.php",
            data: { id: id }
        })
        .done(function( msg ) {
            if(parseInt(msg) == 1){
                
                iziToast.success({
                    title: 'OK',
                    message: 'Test has been deleted successfully: '+questionnaire+' of the teacher: '+ teacher+' in the group: '+subject,
                });
            }else{
                iziToast.error({
                    title: 'Error',
                    message: 'It as not been deleted, Try again later.',
                });
            }
        });
    }

    $(".delete-record").click(function(e){
        let questionnaire = $(this).parent().parent()[0].children[0].innerText;
        let teacher = $(this).parent().parent()[0].children[1].innerText;
        let subject = $(this).parent().parent()[0].children[2].innerText;
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
            message: 'Are you sure you want to delete this test: '+questionnaire+' of the teacher: '+ teacher+' for the group: '+subject,
            position: 'center',
            buttons: [
                ['<button><b>YES</b></button>', function (instance, toast) {
         
                    instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    deleteUser(id,questionnaire,teacher,subject);
                    
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
        $(".questionnaire-input").val("");
        $(".code-input").val("");
        iziToast.success({
            title: 'OK',
            message: 'All fields are clean now.',
        });
    });
});