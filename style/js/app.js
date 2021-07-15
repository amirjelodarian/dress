/* this is for panel */
$(document).ready(function(){

    // commentsList.php Page
    $('#comments-search').keyup(function () {
        var commentsSearch = $("#comments-search").val();
        var commentsOrderBy = $('#comments-order-by').val();
        if (commentsSearch != '' && commentsOrderBy != ''){
            $('#comments-search-result').html('');
            $.ajax({
                url: "commentsListSearchRequests.php",
                method: "post",
                dataType: "text",
                beforeSend: function() {
                    $('.loader-outside').show();
                },
                data: {commentsSearch: commentsSearch,commentsOrderBy: commentsOrderBy},
                success:function (data) {
                    $('#comments-main-result,.loader-outside').hide();
                    $('#comments-search-result').show();
                    $("#comments-search-result").html(data);
                    if (data == "" || data == null){
                        $('#comments-main-result').show();
                    }
                }
            });
        }else{
            $('#comments-main-result').show();
            $('#comments-search-result').hide();
        }
    });
    ///////////////////////////////////////////////////


    // usersList.php Page
    $('#users-search').keyup(function () {
        $('#users-search-result,.loader-outside').hide();
        var usersSearch = $("#users-search").val();
        var usersOrderBy = $('#users-order-by').val();
        if (usersSearch != '' && usersOrderBy != ''){
            $('#users-search-result').html('');
            $.ajax({
                url: "usersListSearchRequests.php",
                method: "post",
                dataType: "text",
                beforeSend: function() {
                    $('.loader-outside').val('Searching...');
                    $('.loader-outside').show();
                },
                data: {usersSearch: usersSearch,usersOrderBy: usersOrderBy},
                success:function (data) {
                    $('#users-main-result,.loader-outside').hide();
                    $('#users-search-result').show();
                    $("#users-search-result").html(data);
                    if (data == "" || data == null){
                        $('#users-search-result').hide();
                    }
                }
            });
        }else{
            $('#users-main-result').show();
        }
    });
    ///////////////////////////////////////////////////

    // index.php Panel Page
    $('#clothes-search').keyup(function () {
        $('#clothes-search-result,.loader-outside').hide();
        var clothesSearch = $("#clothes-search").val();
        var clothesOrderBy = $('#clothes-order-by').val();
        if (clothesSearch != '' && clothesOrderBy != ''){
            $('#clothes-search-result').html('');
            $.ajax({
                url: "indexSearchRequests.php",
                method: "post",
                dataType: "text",
                beforeSend: function() {
                    $('.loader-outside').val('Searching...');
                    $('.loader-outside').show();
                },
                data: {clothesSearch: clothesSearch,clothesOrderBy: clothesOrderBy},
                success:function (data) {
                    $('#clothes-main-result,.loader-outside').hide();
                    $('#clothes-search-result').show();
                    $("#clothes-search-result").html(data);
                    if (data == "" || data == null){
                        $('#clothes-search-result').hide();
                    }
                }
            });
        }else{
            $('#clothes-main-result').show();
        }
    });
    ///////////////////////////////////////////////////


    $(".bars main .box").click(function (){
        $('#mobile-menu').hide();
    });
    $('#menu-btn').click(function (){
        $('#mobile-menu').show();
    });
    if ($(window).width() <= 768){
        $('#bars').css({'width':'0px'});
    }
    $("#limitToNumber,.limitToNumber").keypress(function (e) {
        var ew = e.which || e.keyCode;
        if (ew == 37 || ew == 39 || ew == 8 || ew == 46 || ew == 9 || ew == 33 || ew == 34 || ew == 35 || ew == 36)
            return true;
        if (ew >= 48 && ew <= 57)
            return true;
        if (e.ctrlKey || e.metaKey || e.altKey)
            return true;
        return false;
    });
    $('#close').click(function (){
        $('#bars').css({'width':'0px'});
        $('#header-panel,.main-col').css({'width':'100%'});
    });
    $('#panel-menu-icon').click(function (){
        if($(window).width() > 768){
            $('#bars').css({'width':'25%'});
            $('#header-panel,.main-col').css({'width':'75%'});
        }else if ($(window).width() <= 768){
            $('#bars').css({'width':'250px'});
            $('#header-panel,.main-col').css({'width':'100%'});
        }
    });
    $('.loader-outside,#All-Product-Result').hide();
    $('#AreYouSure,.AreYouSure').click(function(){
        var applyAreYouSure = window.confirm('آیا مطمئن هستید ؟');
        if(applyAreYouSure == true)
            return true;
        else
            return false;
    });


    // Product.php Page
    $('#userMenu,#userSubMenu').change(function () {
        var usermenu = $('#userMenu').val();
        var usersubmenu = $('#userSubMenu').val();
        $('#All-Product').hide();
        $('#All-Product-Result').show();
            if (usermenu !== '' && usersubmenu !== ''){
                $.ajax({
                    url: "productRequest.php",
                    method: "get",
                    dataType: "text",
                    beforeSend: function() {
                        $('.loader-outside').val('Searching...');
                        $('.loader-outside').show();
                    },
                    data: {userMenu: usermenu,userSubMenu: usersubmenu},
                    success:function (data) {
                        $("#All-Product-Result").html(data);
                    }
                });
            }
    });
    $('#userMenu').change(function () {
        var usermenu = $('#userMenu').val();
        $('#All-Product').hide();
        if (usermenu !== ''){
            $.ajax({
                url: "productRequest.php",
                method: "post",
                dataType: "text",
                beforeSend: function() {
                    $('.loader-outside').fadeIn(500);
                },
                data: {userMenu: usermenu},
                success:function (data) {
                    $("#userSubMenu").html(data);

                }
            });
        }
    });
    /////////////////////////////////////////////////////////


    // Dropdown Menu
    var dropdown = document.querySelectorAll('.dropdown');
    var dropdownArray = Array.prototype.slice.call(dropdown,0);
    dropdownArray.forEach(function(el){
        var button = el.querySelector('a[data-toggle="dropdown"]'),
            menu = el.querySelector('.dropdown-menu'),
            arrow = button.querySelector('i.icon-arrow');

        button.onclick = function(event) {
            if(!menu.hasClass('show')) {
                menu.classList.add('show');
                $(button).css({'text-shadow':'2px 3px 5px #007bff'});
                menu.classList.remove('hide');
                arrow.classList.add('open');
                arrow.classList.remove('close');
                event.preventDefault();
            }
            else {
                $(button).css({'text-shadow':'none'});
                menu.classList.remove('show');
                menu.classList.add('hide');
                arrow.classList.remove('open');
                arrow.classList.add('close');
                event.preventDefault();
            }
        };
    });
    Element.prototype.hasClass = function(className) {
        return this.className && new RegExp("(^|\\s)" + className + "(\\s|$)").test(this.className);
    };

    // profile.php Page
    $('.changePasswordBtn').click(function (){
        $('.changePasswordInside').animate({'height': 'toggle'});
    });
    ////////////////////////////////////////////////

    $("#add-product-submit").click(function () {
        /*$("#add-product-form").on('submit',function (e) {
            e.preventDefault();*/
            // var add_product_submit = $("#add-product-submit").val();
            // var add_product = $("#add-product").val();
            var price = $("#clothes-price").val();
            var title = $("#clothes-title").val();
            var description = $("#description").val();
            var type = $("#type-clothes").val();
            var model = $("#model-clothes").val();
            var fabrictype = $("#fabricType-clothes").val();
            var sizeclothes = $("#size-clothes").val();
            var colorclothes = $("#color-clothes").val();
            var offprice = $("#off-price").val();

            // if($("#add-product").val() == ''){
            //     alert('لطفا عکس محصول را انتخاب کنید. !');
            // } else
            if(price !== '' && title !== '' && description !== '' && type !== '' && model !== '' && fabrictype !== '' && sizeclothes !== '' && colorclothes !== '' && offprice !== ''){
                /*$.ajax({
                    url: "panel-req.php",
                    method: "POST",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (data) {
                        alert(data);
                    }
                });*/
            }else{
                alert('برخی از فیلد ها خالیست. !');
            }
        // });
    });


    // $("#add-product-submit").click(function () {
    //     var add_product_submit = $("#add-product-submit").val();
    //     var add_product = $("#add-product").val();
    //     var price = $("#clothes-price").val();
    //     var title = $("#clothes-title").val();
    //     var description = $("#description").val();
    //     var type = $("#type-clothes").val();
    //     var model = $("#model-clothes").val();
    //     var fabrictype = $("#fabricType-clothes").val();
    //     var sizeclothes = $("#size-clothes").val();
    //     var colorclothes = $("#color-clothes").val();
    //     var offprice = $("#off-price").val();
    //     $.ajax({
    //         url: "panel-req.php",
    //         method: "post",
    //         dataType: "text",
    //         /* beforeSend: function() {
    //              // $("#searching").val("...Searching");
    //              // $(".loader").show();
    //          },*/
    //         data: {offPrice : offprice,uploadFile: add_product,price: price,title: title,description: description,type:type,model:model,fabricType:fabrictype,size:sizeclothes,color: colorclothes,addNewProduct : add_product_submit},
    //         success:function (data) {
    //             alert(data);
    //         }
    //     });
    //
    // });


    // profile.php Page
    $('#type-result,#model-result,#fabricType-result,#size-result,#color-result,#edit-profile-panel,#username-message,#email-message,#username-panel-message,#reset-password-message,#messageResetPasswordCode').hide();
    $('.panel-username').keyup(function () {
        var username = $(".panel-username").val();
        if (username != ''){
            $('#username-panel-message').html('');
            $.ajax({
                url: "profileRequest.php",
                method: "get",
                dataType: "text",
                /* beforeSend: function() {
                     // $("#searching").val("...Searching");
                     // $(".loader").show();
                 },*/
                data: {username: username},
                success:function (data) {
                    $('#username-panel-message').show();
                    $("#username-panel-message").html(data);
                    if (data == "" || data == null){
                        $('#username-panel-message').hide();
                    }
                }
            });
        }else{
            $('#username-panel-message').hide();
        }
    });
    //////////////////////////////////////////////////////////


    // register.php Page
    $('#username').keyup(function () {
        var username = $("#username").val();
        if (username != ''){
            $('#username-message').html('');
            $.ajax({
                url: "registerRequest.php",
                method: "get",
                dataType: "text",
                /* beforeSend: function() {
                     // $("#searching").val("...Searching");
                     // $(".loader").show();
                 },*/
                data: {username: username},
                success:function (data) {
                    $('#username-message').show();
                    $("#username-message").html(data);
                    if (data == "" || data == null){
                        $('#username-message').hide();
                    }
                }
            });
        }else{
            $('#username-message').hide();
        }
    });
    $('#email').keyup(function () {
        var email = $("#email").val();
        if (email != ''){
            $('#email-message').html('');
            $.ajax({
                url: "registerRequest.php",
                method: "get",
                dataType: "text",
                /* beforeSend: function() {
                     // $("#searching").val("...Searching");
                     // $(".loader").show();
                 },*/
                data: {email: email},
                success:function (data) {
                    $('#email-message').show();
                    $("#email-message").html(data);
                    if (data == "" || data == null){
                        $('#email-message').hide();
                    }
                }
            });
        }else{
            $('#email-message').hide();
        }
    });
    //////////////////////////////////////////////////////////

    // resetPassword.php And codeVerifyRequests.php Page
    $('#submitCode').click(function (){
        var code = $("#selfCode").val();
        if (code != ''){
            $('#code-message').html('');
            $.ajax({
                url: "codeVerifyRequests.php",
                method: "get",
                dataType: "text",
                beforeSend: function() {
                    $('.loader-outside').val('Searching...');
                    $('.loader-outside').show();
                },
                data: {code: code},
                success:function (data) {
                    $('#code-message').show();
                    $("#code-message").html(data);
                    if (data == "" || data == null){
                        $('#code-message').hide();
                    }
                }
            });
        }else{
            $('#code-message').hide();
        }
    });
    $('#send-email-verify-panel').click(function (){
        $('.loader-outside').show();
        var email = $("#email-verify-panel").val();
        var sendEmailVerifyPanel = $('#send-email-verify-panel').val();
        if (sendEmailVerifyPanel != '' && email != ''){
            $('#verify-message').html('');
            $.ajax({
                url: "codeVerifyRequests.php",
                method: "get",
                dataType: "text",
                data: {sendEmailVerifyPanel: sendEmailVerifyPanel,email: email},
                success:function (data) {
                    $('.loader-outside').hide();
                    $('#verify-message').show();
                    $("#verify-message").html(data);
                    if (data == "" || data == null){
                        $('#verify-message').hide();
                    }
                }
            });
        }else{
            $('#verify-message').hide();
        }
    });
    //////////////////////////////////////////////////////////


    // resetPassword.php Page
    $('#reset-password-btn').click(function (){
        $('.loader-outside').show();
        var emailOrUsername = $("#emailOrUsername").val();
        if (emailOrUsername != ''){
            $('#reset-password-message').html('');
            $.ajax({
                url: "resetPasswordRequest.php",
                method: "get",
                dataType: "text",
                // beforeSend: function() {
                //     $('.loader-outside').val('Searching...');
                //     $('.loader-outside').show();
                // },
                data: {emailOrUsername: emailOrUsername},
                success:function (data) {
                    $('.loader-outside').hide();
                    $('#reset-password-message').show();
                    $("#reset-password-message").html(data);
                    if (data == "" || data == null){
                        $('#reset-password-message').hide();
                    }
                }
            });
        }else{
            $('#reset-password-message').hide();
        }
    });
    //////////////////////////////////////////////////////////


    // panel-req.php Page For addProduct.php Page
    $('#type-clothes').keyup(function () {
        var type_clothes = $("#type-clothes").val();
        if (type_clothes != ''){
            $('#type-result').html('');
            $.ajax({
                url: "panel-req.php",
                method: "get",
                dataType: "text",
               /* beforeSend: function() {
                    // $("#searching").val("...Searching");
                    // $(".loader").show();
                },*/
                data: {type: type_clothes},
                success:function (data) {
                    $('#type-result').show();
                    $("#type-result").html(data);
                    if (data == "" || data == null){
                        $('#type-result').hide();
                    }
                }
            });
        }else{
            $('#type-result').hide();
        }
    });
    $('#model-clothes').keyup(function () {
        var model_clothes = $("#model-clothes").val();
        if (model_clothes != ''){
            $('#model-result').html('');
            $.ajax({
                url: "panel-req.php",
                method: "get",
                dataType: "text",
                /* beforeSend: function() {
                     // $("#searching").val("...Searching");
                     // $(".loader").show();
                 },*/
                data: {model: model_clothes},
                success:function (data) {
                    $('#model-result').show();
                    $("#model-result").html(data);
                    if (data == "" || data == null){
                        $('#model-result').hide();
                    }
                }
            });
        }else{
            $('#model-result').hide();
        }
    });
    $('#fabricType-clothes').keyup(function () {
        var fabricType_clothes = $("#fabricType-clothes").val();
        if (fabricType_clothes != ''){
            $('#fabricType-result').html('');
            $.ajax({
                url: "panel-req.php",
                method: "get",
                dataType: "text",
                /* beforeSend: function() {
                     // $("#searching").val("...Searching");
                     // $(".loader").show();
                 },*/
                data: {fabricType: fabricType_clothes},
                success:function (data) {
                    $('#fabricType-result').show();
                    $("#fabricType-result").html(data);
                    if (data == "" || data == null){
                        $('#fabricType-result').hide();
                    }
                }
            });
        }else{
            $('#fabricType-result').hide();
        }
    });
    $('#size-clothes').keyup(function () {
        var size_clothes = $("#size-clothes").val();
        if (size_clothes != ''){
            $('#size-result').html('');
            $.ajax({
                url: "panel-req.php",
                method: "get",
                dataType: "text",
                /* beforeSend: function() {
                     // $("#searching").val("...Searching");
                     // $(".loader").show();
                 },*/
                data: {size: size_clothes},
                success:function (data) {
                    $('#size-result').show();
                    $("#size-result").html(data);
                    if (data == "" || data == null){
                        $('#size-result').hide();
                    }
                }
            });
        }else{
            $('#size-result').hide();
        }
    });
    $('#color-clothes').keyup(function () {
        var color_clothes = $("#color-clothes").val();
        if (color_clothes != ''){
            $('#color-result').html('');
            $.ajax({
                url: "panel-req.php",
                method: "get",
                dataType: "text",
                /* beforeSend: function() {
                     // $("#searching").val("...Searching");
                     // $(".loader").show();
                 },*/
                data: {color: color_clothes},
                success:function (data) {
                    $('#color-result').show();
                    $("#color-result").html(data);
                    if (data == "" || data == null){
                        $('#color-result').hide();
                    }
                }
            });
        }else{
            $('#color-result').hide();
        }
    });
    $("#edit-profile-panel").hide();
    //////////////////////////////////////////////////////////

    // moreProduct.php Page
    $('#priceRange,#priceRange2').ionRangeSlider({
        hide_min_max: !0,
        keyboard: !0,
        min: 1000,
        max: 50000000,
        from: 1000,
        to: 13000000,
        type: "int",
        step: 10000,
        prefix: "",
        grid: !0
    });
    //////////////////////////////////////////////////////////


    // singleProduct.php
    $('#comment-submit').click(function (){
        var comment_title = $("#comment-title").val();
        var comment_description = $('#comment-description').val();
        var product_id = $('#product-id').val();
        var comment_score = $('#comment-score').val();

        if (comment_title != '' && comment_description != '' && product_id != ''){
            $('#verify-message').html('');
            $.ajax({
                url: "singleProductRequest.php",
                method: "post",
                dataType: "text",
                data: {title: comment_title,description: comment_description,productId: product_id,score: comment_score},
                success:function (data) {
                    $('.loader-outside').hide();
                    $('#verify-message').show();
                    $("#verify-message").html(data);
                    if (data == "" || data == null){
                        $('#verify-message').hide();
                    }
                }
            });
        }else{
            $("#verify-message").html('برخی فیلد ها خالی است');

        }
    });
    //////////////////////////////////////////////////////////

    $("#For-Man,#For-Woman").change(function () {
        location = this.options[this.selectedIndex].value;
    });


    $('#header-panel .fa-bars').click(function () {
        $('.panels').css('right','0');
        $('#header-panel,#main-for-panel,.main-col').css('width','75%');
        $('#header-panel .fa-bars').hide();
    });
    $('#close').click(function () {
        $('.panels').css('right','-100%');
        $('#header-panel,#main-for-panel,.main-col').css('width','100%');
        $('#header-panel .fa-bars').show();
    })
    $('#dashboard').click(function () {
        $('#main-for-panel #for-dashboard').slideToggle();
        $('#for-product').slideUp();
        $('#Pirhan2').slideUp();
        $('#T-shrt2').slideUp();
        $('#Pants2').slideUp();
        $('#underDressman2').slideUp();
        $('#fallKoat2').slideUp();
        $('#paltoman2').slideUp();
        $('#jelighe2').slideUp();
        $('#koat2').slideUp();
        $('#zhakat2').slideUp();
        $('#hodi2').slideUp();
        $('#jin2').slideUp();
        $('#sox2').slideUp();
    })
    $('#add').click(function () {
        $('#for-product').slideToggle();
        $('#main-for-panel #for-dashboard').slideUp();
        $('#Pirhan2').slideUp();
        $('#T-shrt2').slideUp();
        $('#Pants2').slideUp();
        $('#underDressman2').slideUp();
        $('#fallKoat2').slideUp();
        $('#paltoman2').slideUp();
        $('#jelighe2').slideUp();
        $('#koat2').slideUp();
        $('#zhakat2').slideUp();
        $('#hodi2').slideUp();
        $('#jin2').slideUp();
        $('#sox2').slideUp();
    });


    /* End Panel */
});

function login() {
    document.getElementById('main-for-login').style.display="block";
    document.getElementById('signUp').style.display="none";
    document.getElementById('login2').style.background="gray";
    document.getElementById('login2').style.color="white";
    document.getElementById('signUp2').style.color="black";
    document.getElementById('signUp2').style.background="white";
    document.getElementById('signUp2').style.borderBottom="1px solid #eeeeee";
}
function SignUp() {
    document.getElementById('main-for-login').style.display="none";
    document.getElementById('signUp').style.display="block";
    document.getElementById('login2').style.background="white";
    document.getElementById('login2').style.borderBottom="1px solid #eeeeee";
    document.getElementById('login2').style.color="black";
    document.getElementById('signUp2').style.background="gray";
    document.getElementById('signUp2').style.color="white";
}
function forgot() {
    document.getElementById('main-for-login').style.display="none";
    document.getElementById('signUp').style.display="none";
    document.getElementById('login2').style.background="white";
    document.getElementById('login2').style.color="black";
    document.getElementById('signUp2').style.background="white";
    document.getElementById('signUp2').style.color="black";
    document.getElementById('login2').style.borderBottom="1px solid #eeeeee";
    document.getElementById('signUp2').style.borderBottom="1px solid #eeeeee";
}
$('#colorr1').click(function () {
    $('.online .fa-tshirt').css('color','black');
    $('.online').css('background-color','white');
})
$('#colorr2').click(function () {
    $('.online .fa-tshirt').css('color','gray');
    $('.online').css('background-color','black');
})
$('#colorr3').click(function () {
    $('.online .fa-tshirt').css('color','saddlebrown');
    $('.online').css('background-color','black');
})
$('#colorr4').click(function () {
    $('.online .fa-tshirt').css('color','#ffffff');
    $('.online').css('background-color','black');
})
$('#colorr5').click(function () {
    $('.online .fa-tshirt').css('color','orange');
    $('.online').css('background-color','black');
})
$('#colorr6').click(function () {
    $('.online .fa-tshirt').css('color','red');
    $('.online').css('background-color','black');
})
$('#colorr7').click(function () {
    $('.online .fa-tshirt').css('color','pink');
    $('.online').css('background-color','black');
})
$('#colorr8').click(function () {
    $('.online .fa-tshirt').css('color','navy');
    $('.online').css('background-color','black');
})
$('#colorr9').click(function () {
    $('.online .fa-tshirt').css('color','lightblue');
    $('.online').css('background-color','black');
})
$('#colorr10').click(function () {
    $('.online .fa-tshirt').css('color','green');
    $('.online').css('background-color','black');
})
$('#colorr11').click(function () {
    $('.online .fa-tshirt').css('color','greenyellow');
    $('.online').css('background-color','black');
})
$('#colorr12').click(function () {
    $('.online .fa-tshirt').css('color','yellow');
    $('.online').css('background-color','black');
})

$('#btn-fornt').click(function () {
    $('#input-front').show();
    $('.frontText').show();
})
$('#btn-back').click(function () {
    $('#input-back').show();
    $('.backText').show();
})
function MyScroll() {
    document.getElementById('level2').style.animation="first 2s";
    document.getElementById('level3').style.animation="two 2s";
    document.getElementById('level4').style.animation="first 2s";
    document.getElementById('level5').style.animation="two 2s";
    document.getElementById('level6').style.animation="first 2s";
    document.getElementById('level1').style.animation="two 2s";
}
function MyChange() {
    var x = document.getElementById('Select-file');
    if (x.value=='yes'){
        document.getElementById('file1').style.display='block';
        document.getElementById('file2').style.display='block';
        document.getElementById('tarh').style.display='flex';
    }
    if (x.value=='no'){
        document.getElementById('file1').style.display='none';
        document.getElementById('file2').style.display='none';
        document.getElementById('tarh').style.display='none';
    }
}
function check() {
    document.getElementById('bgc').style.background="red";
}

$('.filter').click(function () {
    $('.about-filter').slideToggle();
})
$('.fa-bars').click(function () {
    $('.bars').css('right','0');
})
$('.fa-times').click(function () {
    $('.bars').css('right','-100%');
});
function gender() {
    var m = document.getElementById('Gender');
    if (m.value=='man'){
        document.getElementById('all-woman').style.display="none";
        document.getElementById('all-man').style.display="block";
        document.getElementById('Woman').style.display="none";
        document.getElementById('Man').style.display="block";
    }
    if (m.value=='woman'){
        document.getElementById('all-woman').style.display="block";
        document.getElementById('all-man').style.display="none";
        document.getElementById('Man').style.display="none";
        document.getElementById('Woman').style.display="block";
    }
}
$('.Mark .fa-angle-down').click(function () {
    $('.div1').slideToggle();
    $('.div2').slideToggle();
    $('.div3').slideToggle();
    $('.div4').slideToggle();
})
function test() {
    var a = document.getElementById('Gender');
    if (a.value=='man'){
        document.getElementById('Man').style.display="block";
        document.getElementById('Woman').style.display="none";
        document.getElementById('Boy').style.display="none";
        document.getElementById('Girl').style.display="none";
        document.getElementById('Baby').style.display="none";
    }
    if (a.value=='woman'){
        document.getElementById('Man').style.display="none";
        document.getElementById('Woman').style.display="block";
        document.getElementById('Boy').style.display="none";
        document.getElementById('Girl').style.display="none";
        document.getElementById('Baby').style.display="none";
    }
    if (a.value=='boy'){
        document.getElementById('Man').style.display="none";
        document.getElementById('Woman').style.display="none";
        document.getElementById('Boy').style.display="block";
        document.getElementById('Girl').style.display="none";
        document.getElementById('Baby').style.display="none";
    }
    if (a.value=='girl'){
        document.getElementById('Man').style.display="none";
        document.getElementById('Woman').style.display="none";
        document.getElementById('Boy').style.display="none";
        document.getElementById('Girl').style.display="block";
        document.getElementById('Baby').style.display="none";
    }
    if (a.value=='baby'){
        document.getElementById('Man').style.display="none";
        document.getElementById('Woman').style.display="none";
        document.getElementById('Boy').style.display="none";
        document.getElementById('Girl').style.display="none";
        document.getElementById('Baby').style.display="block";
    }
}
// Start-For-Woman
//     function forwoman(){
//         var c = document.getElementById('For-Woman');
//         if (c.value=='manto'){
//             document.getElementById('manto').style.display="block";
//         }
//     }
// End-For-Woman
$('.fa-bars').click(function () {
    $('.bars').css('right','0');
});
$('.fa-times').click(function () {
    $('.bars').css('right','-100%');
});
function addOption(id_name) {
    var select = document.getElementById(id_name);
    var option = document.createElement("option");
    option.text = "Kiwi";
    select.add(option);
}
function changePanel() {
    var j = document.getElementById('select-panel');
    if(j.value=='manP'){
        document.getElementById('manPanel').style.display="inline-block";
        document.getElementById('womanPanel').style.display="none";
    }
    if(j.value=='womanP'){
        document.getElementById('manPanel').style.display="none";
        document.getElementById('womanPanel').style.display="inline-block";
    }
}
function off2(){
    var k = document.getElementById('offf').value;
    document.getElementById('off-place').innerText = k ;
}
function slideToggle(div){
    $(div).slideToggle();
}
function resetPassword(){
    var selfResetPasswordCode = $('#selfResetPasswordCode').val();
    if (selfResetPasswordCode != ''){
        $('#messageResetPasswordCode').html('');
        $.ajax({
            url: "resetPasswordRequest.php",
            method: "get",
            dataType: "text",
            data: {selfResetPasswordCode: selfResetPasswordCode},
            success:function (data) {
                $('#messageResetPasswordCode').show();
                $("#messageResetPasswordCode").html(data);
                if (data == "" || data == null){
                    $('#messageResetPasswordCode').hide();
                }
            }
        });
    }else{
        $('#messageResetPasswordCode').hide();
    }
}
function resetPasswordLastStep(div){
    var resetPasswordInput = $('#resetPasswordInput').val();
    var resetPasswordInputConfirm = $('#resetPasswordInputConfirm').val();
    if (resetPasswordInput != '' && resetPasswordInputConfirm != ''){
        $('.reset-password-last-e-message').html('');
        $.ajax({
            url: "resetPasswordRequest.php",
            method: "post",
            dataType: "text",
            data: {resetPasswordInput: resetPasswordInput,resetPasswordInputConfirm: resetPasswordInputConfirm},
            success:function (data) {
                $('.reset-password-last-e-message').show();
                $(".reset-password-last-e-message").html(data);
                if (data == "" || data == null){
                    $('.reset-password-last-e-message').hide();
                }
            }
        });
    }else{
        $('.reset-password-last-e-message').hide();
    }
}
function liveEdit(elementName){
    $(elementName).click(function (){
        $(elementName).each(function () {
            //Reference the Label.
            var label = $(this);
            //Add a TextBox next to the Label.
            label.after("<input type = 'text' style = 'display:none' />");

            //Reference the TextBox.
            var textbox = $(this).next();

            //Set the name attribute of the TextBox.
            textbox[0].name = this.id.replace("lbl", "txt");

            //Assign the value of Label to TextBox.
            textbox.val(label.html());

            //When Label is clicked, hide Label and show TextBox.
            label.click(function () {
                $(this).hide();
                $(this).next().show();
            });

            //When focus is lost from TextBox, hide TextBox and show Label.
            textbox.focusout(function () {
                $(this).hide();
                $(this).prev().html($(this).val());
                $(this).prev().show();
                var varElementId = elementName+"Id";
                var varId = this.name;
                var varElementValue = elementName+"Value";
                var varValue = this.value;
                $.ajax({
                    url: "editCommentsRequests.php",
                    method: "post",
                    dataType: "text",
                    // beforeSend: function() {
                    //     $('.loader-outside').fadeIn(500);
                    // },
                    data: {commentTitleId: commentTitleId,commentTitleValue: commentTitleValue},
                    success:function (data) {
                        $("#comment_result").html(data);
                    }
                });
            });
        });

    });
}
function startTime() {
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('today-time').innerHTML =
        h + ":" + m + ":" + s;
    var t = setTimeout(startTime, 500);
}
function checkTime(i) {
    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
    return i;
}
function increaseValue(id,maxValue) {
    var value = parseInt(document.getElementById('number-'+id).value, 10);
    var increase = document.getElementById('increase-'+id);
    if (maxValue > value){
        value = isNaN(value) ? 1 : value;
        value++;
        if(value == (maxValue))
            increase.style.display = "none";
        else
            increase.style.display = "inline-block";
    }
    document.getElementById('number-'+id).value = value;
}

function decreaseValue(id,maxValue) {
    var value = parseInt(document.getElementById('number-'+id).value, 10);
    var increase = document.getElementById('increase-'+id);
    value = isNaN(value) ? 1 : value;
    value < 1 ? value = 1 : '';
    value--;
    if(value == (maxValue))
        increase.style.display = "none";
    else
        increase.style.display = "inline-block";
    document.getElementById('number-'+id).value = value;
}
function increaseValueSingleProduct(maxValue) {
    var value = parseInt(document.getElementById('number').value, 10);
    var increase = document.getElementById('increase');
    if (maxValue > value){
        value = isNaN(value) ? 1 : value;
        value++;
        if(value == (maxValue))
            increase.style.display = "none";
        else
            increase.style.display = "inline-block";
    }
    document.getElementById('number').value = value;
}

function decreaseValueSingleProduct(maxValue) {
    var value = parseInt(document.getElementById('number').value, 10);
    var increase = document.getElementById('increase');
    value = isNaN(value) ? 1 : value;
    value < 1 ? value = 1 : '';
    value--;
    if(value == (maxValue))
        increase.style.display = "none";
    else
        increase.style.display = "inline-block";
    document.getElementById('number').value = value;
}