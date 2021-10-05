$(document).ready(function () {

    $(document).on('click', '.sbHolder ul.sbOptions li a', function (e) {
        e.preventDefault()
        window.location.href = $(this).attr('rel')
    })

    var inputmask_uz_phone = {"mask": "+\\9\\98\\(99\\) 999-99-99"};

    // $(".masked-input-phone").inputmask(inputmask_uz_phone);


    $('.logout-menu-link').click(function (e) {
        e.preventDefault()
        $('form#logout-form').submit()
    })


    /**
     * Wish List Start
     **/

    $(document).on('click', '.add-to-wishlist', function (e) {

        e.preventDefault()
        let url = $(this).data('url')
        let button = $(this)
        $.ajax({
            url: url,
            success: function (result) {

                let success = result.success
                let message = result.message
                let action = result.action

                if(action === 'added'){

                    button.addClass('wished_bt')
                    console.log(button)
                    toastr.info(message)
                    return ;
                }

                if(action === 'removed'){

                    button.removeClass('wished_bt')
                    toastr.warning(message)
                    return ;
                }


                if(!success && message){
                    toastr.error(message)
                }

            }
        });

    })


    /**
     * Wish List End
     **/


})