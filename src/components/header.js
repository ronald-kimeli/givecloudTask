$(document).ready(function() {
    let link = '';

    if (link = 'contributions') {
        $(`#${link}`).click(function(e) {
            e.preventDefault();                 
            const userid = e.target.id;
            $.ajax({
                url: 'data.php',
                type: 'post',
                data: {
                    userid: userid
                },
                success: function(response) {
                    $('#apidata').html('');
                    $('.card-title').html('');
                    $('.card-title').append(userid);
                    $('#apidata').append(response);
                    $('#example').DataTable({});
                }
            });
        });
    }
    
    
    if (link = 'supporters') {
        $(`#${link}`).click(function(e) {
            e.preventDefault();                 
            const userid = e.target.id;
            $.ajax({
                url: 'data.php',
                type: 'post',
                data: {
                    userid: userid
                },
                success: function(response) {
                    $('#apidata').html('');
                    $('.card-title').html('');
                    $('.card-title').append(userid);
                    $('#apidata').append(response);
                    $('#example').DataTable({});
                }
            });
        });
    }

    if (link = 'recurringsupporter') {
        $(`#${link}`).click(function(e) {
            e.preventDefault();                 
            const userid = e.target.id;
            $.ajax({
                url: 'data.php',
                type: 'post',
                data: {
                    userid: userid
                },
                success: function(response) {
                    $('#apidata').html('');
                    $('.card-title').html('');
                    $('.card-title').append(userid);
                    $('#apidata').append(response);
                    $('#example').DataTable({});
                }
            });
        });
    }

    if (link = 'cancelledsupporters') {
        $(`#${link}`).click(function(e) {
            e.preventDefault();                 
            const userid = e.target.id;
            $.ajax({
                url: 'data.php',
                type: 'post',
                data: {
                    userid: userid
                },
                success: function(response) {
                    $('#apidata').html('');
                    $('.card-title').html('');
                    $('.card-title').append(userid);
                    $('#apidata').append(response);
                    $('#example').DataTable({});
                }
            });
        });
    }

    const userid = 'contributions';
    $.ajax({
        url: 'data.php',
        type: 'post',
        data: {
            userid: userid
        },
        success: function(response) {
            $('#apidata').html('');
            $('.card-title').html('');
            $('.card-title').append(userid);
            $('#apidata').append(response);
            $('#example').DataTable({});
        }
    });

});