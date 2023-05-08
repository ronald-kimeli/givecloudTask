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
    
    
    $("#reducedArray").click(function (e) { 
        e.preventDefault();
        
        $.ajax({
            type: "GET",
            url: "overall.php",
            dataType: "JSON",
            success: function (response) {
                // let reducedArray =  response.reduce((obj, item) => {
                //     obj[item.email] ? obj[item.email].elements.push(...item.elements) : obj[item.email] = item
                //     return obj
                // },{})
                
                const reducedArray = response.reduce((resultArray, arrayElement) => {
                    const elementIndex = resultArray.findIndex(element => element.email === arrayElement.email);
                  
                    if (elementIndex !== -1) {
                      resultArray[elementIndex].total_amount.push(arrayElement.total_amount)
                    } else {
                      resultArray.push({
                        ...arrayElement,
                        total_amount: [arrayElement.total_amount],
                      });
                    }
                    return resultArray;
                  }, []);
                
                console.log(reducedArray);
                // document.write("<?php echo $reducedArray ?>");
                document.getElementById('reducedArray').innerHTML = '<?= $greeting; ?>';
            
            }
        });
        
    });

});