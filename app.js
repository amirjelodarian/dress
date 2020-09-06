
$(document).ready(function(){
    $("#For-Man").change(function () {
        location = this.options[this.selectedIndex].value;
    });
});
$(document).ready(function(){
    $("#For-Woman").change(function () {
        location = this.options[this.selectedIndex].value;
    });
});
function login() {
    document.getElementById('main-for-login').style.display="block";
    document.getElementById('forgot').style.display="none";
    document.getElementById('signUp').style.display="none";
    document.getElementById('login2').style.background="gray";
    document.getElementById('login2').style.color="white";
    document.getElementById('signUp2').style.color="black";
    document.getElementById('signUp2').style.background="white";
    document.getElementById('signUp2').style.borderBottom="1px solid #eeeeee";
}
function SignUp() {
    document.getElementById('main-for-login').style.display="none";
    document.getElementById('forgot').style.display="none";
    document.getElementById('signUp').style.display="block";
    document.getElementById('login2').style.background="white";
    document.getElementById('login2').style.borderBottom="1px solid #eeeeee";
    document.getElementById('login2').style.color="black";
    document.getElementById('signUp2').style.background="gray";
    document.getElementById('signUp2').style.color="white";
}
function forgot() {
    document.getElementById('main-for-login').style.display="none";
    document.getElementById('forgot').style.display="block";
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
function yourtext(){
    var m = document.getElementById('your-text');
    if (m.value=='are'){
        document.getElementById('your-button').style.display="block";
    }
    if (m.value=='na'){
        document.getElementById('your-button').style.display="none";
        document.getElementById('frontText').style.display="none";
        document.getElementById('frontText2').style.display="none";
        document.getElementById('backText').style.display="none";
        document.getElementById('backText2').style.display="none";
        document.getElementById('input-front').style.display="none";
        document.getElementById('input-back').style.display="none";
    }
}
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
function link1() {
    document.getElementById('check1').style.display="block";
    document.getElementById('check2').style.display="none";
    document.getElementById('check3').style.display="none";
    document.getElementById('check4').style.display="none";
}
function link2() {
    document.getElementById('check2').style.display="block";
    document.getElementById('check3').style.display="none";
    document.getElementById('check4').style.display="none";
    document.getElementById('check1').style.display="none";
}
function link3() {
    document.getElementById('check3').style.display="block";
    document.getElementById('check4').style.display="none";
    document.getElementById('check1').style.display="none";
    document.getElementById('check2').style.display="none";
}
function link4() {
    document.getElementById('check4').style.display="block";
    document.getElementById('check1').style.display="none";
    document.getElementById('check2').style.display="none";
    document.getElementById('check3').style.display="none";
}
function link5() {
    document.getElementById('check5').style.display="block";
    document.getElementById('check6').style.display="none";
    document.getElementById('check7').style.display="none";
    document.getElementById('check8').style.display="none";
    document.getElementById('check9').style.display="none";
    document.getElementById('check10').style.display="none";
    document.getElementById('check11').style.display="none";
    document.getElementById('check12').style.display="none";
    document.getElementById('check13').style.display="none";
    document.getElementById('check14').style.display="none";
    document.getElementById('check15').style.display="none";
    document.getElementById('check16').style.display="none";
}
function link6() {
    document.getElementById('check5').style.display="none";
    document.getElementById('check6').style.display="block";
    document.getElementById('check7').style.display="none";
    document.getElementById('check8').style.display="none";
    document.getElementById('check9').style.display="none";
    document.getElementById('check10').style.display="none";
    document.getElementById('check11').style.display="none";
    document.getElementById('check12').style.display="none";
    document.getElementById('check13').style.display="none";
    document.getElementById('check14').style.display="none";
    document.getElementById('check15').style.display="none";
    document.getElementById('check16').style.display="none";
}
function link7() {
    document.getElementById('check5').style.display="none";
    document.getElementById('check6').style.display="none";
    document.getElementById('check7').style.display="block";
    document.getElementById('check8').style.display="none";
    document.getElementById('check9').style.display="none";
    document.getElementById('check10').style.display="none";
    document.getElementById('check11').style.display="none";
    document.getElementById('check12').style.display="none";
    document.getElementById('check13').style.display="none";
    document.getElementById('check14').style.display="none";
    document.getElementById('check15').style.display="none";
    document.getElementById('check16').style.display="none";
}
function link8() {
    document.getElementById('check5').style.display="none";
    document.getElementById('check6').style.display="none";
    document.getElementById('check7').style.display="none";
    document.getElementById('check8').style.display="block";
    document.getElementById('check9').style.display="none";
    document.getElementById('check10').style.display="none";
    document.getElementById('check11').style.display="none";
    document.getElementById('check12').style.display="none";
    document.getElementById('check13').style.display="none";
    document.getElementById('check14').style.display="none";
    document.getElementById('check15').style.display="none";
    document.getElementById('check16').style.display="none";
}
function link9() {
    document.getElementById('check5').style.display="none";
    document.getElementById('check6').style.display="none";
    document.getElementById('check7').style.display="none";
    document.getElementById('check8').style.display="none";
    document.getElementById('check9').style.display="block";
    document.getElementById('check10').style.display="none";
    document.getElementById('check11').style.display="none";
    document.getElementById('check12').style.display="none";
    document.getElementById('check13').style.display="none";
    document.getElementById('check14').style.display="none";
    document.getElementById('check15').style.display="none";
    document.getElementById('check16').style.display="none";
}
function link10() {
    document.getElementById('check5').style.display="none";
    document.getElementById('check6').style.display="none";
    document.getElementById('check7').style.display="none";
    document.getElementById('check8').style.display="none";
    document.getElementById('check9').style.display="none";
    document.getElementById('check10').style.display="block";
    document.getElementById('check11').style.display="none";
    document.getElementById('check12').style.display="none";
    document.getElementById('check13').style.display="none";
    document.getElementById('check14').style.display="none";
    document.getElementById('check15').style.display="none";
    document.getElementById('check16').style.display="none";
}
function link11() {
    document.getElementById('check5').style.display="none";
    document.getElementById('check6').style.display="none";
    document.getElementById('check7').style.display="none";
    document.getElementById('check8').style.display="none";
    document.getElementById('check9').style.display="none";
    document.getElementById('check10').style.display="none";
    document.getElementById('check11').style.display="block";
    document.getElementById('check12').style.display="none";
    document.getElementById('check13').style.display="none";
    document.getElementById('check14').style.display="none";
    document.getElementById('check15').style.display="none";
    document.getElementById('check16').style.display="none";
}
function link12() {
    document.getElementById('check5').style.display="none";
    document.getElementById('check6').style.display="none";
    document.getElementById('check7').style.display="none";
    document.getElementById('check8').style.display="none";
    document.getElementById('check9').style.display="none";
    document.getElementById('check10').style.display="none";
    document.getElementById('check11').style.display="none";
    document.getElementById('check12').style.display="block";
    document.getElementById('check13').style.display="none";
    document.getElementById('check14').style.display="none";
    document.getElementById('check15').style.display="none";
    document.getElementById('check16').style.display="none";
}
function link13() {
    document.getElementById('check5').style.display="none";
    document.getElementById('check6').style.display="none";
    document.getElementById('check7').style.display="none";
    document.getElementById('check8').style.display="none";
    document.getElementById('check9').style.display="none";
    document.getElementById('check10').style.display="none";
    document.getElementById('check11').style.display="none";
    document.getElementById('check12').style.display="none";
    document.getElementById('check13').style.display="block";
    document.getElementById('check14').style.display="none";
    document.getElementById('check15').style.display="none";
    document.getElementById('check16').style.display="none";
}
function link14() {
    document.getElementById('check5').style.display="none";
    document.getElementById('check6').style.display="none";
    document.getElementById('check7').style.display="none";
    document.getElementById('check8').style.display="none";
    document.getElementById('check9').style.display="none";
    document.getElementById('check10').style.display="none";
    document.getElementById('check11').style.display="none";
    document.getElementById('check12').style.display="none";
    document.getElementById('check13').style.display="none";
    document.getElementById('check14').style.display="block";
    document.getElementById('check15').style.display="none";
    document.getElementById('check16').style.display="none";
}
function link15() {
    document.getElementById('check5').style.display="none";
    document.getElementById('check6').style.display="none";
    document.getElementById('check7').style.display="none";
    document.getElementById('check8').style.display="none";
    document.getElementById('check9').style.display="none";
    document.getElementById('check10').style.display="none";
    document.getElementById('check11').style.display="none";
    document.getElementById('check12').style.display="none";
    document.getElementById('check13').style.display="none";
    document.getElementById('check14').style.display="none";
    document.getElementById('check16').style.display="none";
    document.getElementById('check15').style.display="block";
}
function link16() {
    document.getElementById('check5').style.display="none";
    document.getElementById('check6').style.display="none";
    document.getElementById('check7').style.display="none";
    document.getElementById('check8').style.display="none";
    document.getElementById('check9').style.display="none";
    document.getElementById('check10').style.display="none";
    document.getElementById('check11').style.display="none";
    document.getElementById('check12').style.display="none";
    document.getElementById('check13').style.display="none";
    document.getElementById('check14').style.display="none";
    document.getElementById('check16').style.display="block";
    document.getElementById('check15').style.display="none";
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
function r_side() {
    if (document.body.scrollTop > 101 || document.documentElement.scrollTop > 101){
        document.getElementById('r-desk').style.top = 0;
        document.getElementById('r-desk').style.marginTop = 0;
    }
    else if(document.body.scrollTop < 100 || document.documentElement.scrollTop < 100){
        document.getElementById('r-desk').style.marginTop = 100+"px";
    }
}
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
// function mann(){
//     var b = document.getElementById('For-Man');
//     if (b.value=="Tshert"){
//         document.getElementById('T-shrt').style.display="block";
//         document.getElementById('Pirhan').style.display="none";
//         document.getElementById('Pants').style.display="none";
//         document.getElementById('underDressman').style.display="none";
//         document.getElementById('fallKoat').style.display="none";
//         document.getElementById('paltoman').style.display="none";
//         document.getElementById('jelighe').style.display="none";
//         document.getElementById('koat').style.display="none";
//         document.getElementById('zhakat').style.display="none";
//         document.getElementById('hodi').style.display="none";
//         document.getElementById('jin').style.display="none";
//         document.getElementById('sox').style.display="none";
//     }
//     if (b.value=='pirhan'){
//         document.getElementById('T-shrt').style.display="none";
//         document.getElementById('Pirhan').style.display="block";
//         document.getElementById('Pants').style.display="none";
//         document.getElementById('underDressman').style.display="none";
//         document.getElementById('fallKoat').style.display="none";
//         document.getElementById('paltoman').style.display="none";
//         document.getElementById('jelighe').style.display="none";
//         document.getElementById('koat').style.display="none";
//         document.getElementById('zhakat').style.display="none";
//         document.getElementById('hodi').style.display="none";
//         document.getElementById('jin').style.display="none";
//         document.getElementById('sox').style.display="none";
//     }
//     if (b.value=='Pants'){
//         document.getElementById('T-shrt').style.display="none";
//         document.getElementById('Pirhan').style.display="none";
//         document.getElementById('Pants').style.display="block";
//         document.getElementById('underDressman').style.display="none";
//         document.getElementById('fallKoat').style.display="none";
//         document.getElementById('paltoman').style.display="none";
//         document.getElementById('jelighe').style.display="none";
//         document.getElementById('koat').style.display="none";
//         document.getElementById('zhakat').style.display="none";
//         document.getElementById('hodi').style.display="none";
//         document.getElementById('jin').style.display="none";
//         document.getElementById('sox').style.display="none";
//     }
//     if (b.value=='underDress'){
//         document.getElementById('T-shrt').style.display="none";
//         document.getElementById('Pirhan').style.display="none";
//         document.getElementById('Pants').style.display="none";
//         document.getElementById('underDressman').style.display="block";
//         document.getElementById('fallKoat').style.display="none";
//         document.getElementById('paltoman').style.display="none";
//         document.getElementById('jelighe').style.display="none";
//         document.getElementById('koat').style.display="none";
//         document.getElementById('zhakat').style.display="none";
//         document.getElementById('hodi').style.display="none";
//         document.getElementById('jin').style.display="none";
//         document.getElementById('sox').style.display="none";
//     }
//     if (b.value=='fallKoat'){
//         document.getElementById('T-shrt').style.display="none";
//         document.getElementById('Pirhan').style.display="none";
//         document.getElementById('Pants').style.display="none";
//         document.getElementById('underDressman').style.display="none";
//         document.getElementById('fallKoat').style.display="block";
//         document.getElementById('paltoman').style.display="none";
//         document.getElementById('jelighe').style.display="none";
//         document.getElementById('koat').style.display="none";
//         document.getElementById('zhakat').style.display="none";
//         document.getElementById('hodi').style.display="none";
//         document.getElementById('jin').style.display="none";
//         document.getElementById('sox').style.display="none";
//     }
//     if (b.value=='palto'){
//         document.getElementById('T-shrt').style.display="none";
//         document.getElementById('Pirhan').style.display="none";
//         document.getElementById('Pants').style.display="none";
//         document.getElementById('underDressman').style.display="none";
//         document.getElementById('fallKoat').style.display="none";
//         document.getElementById('paltoman').style.display="block";
//         document.getElementById('jelighe').style.display="none";
//         document.getElementById('koat').style.display="none";
//         document.getElementById('zhakat').style.display="none";
//         document.getElementById('hodi').style.display="none";
//         document.getElementById('jin').style.display="none";
//         document.getElementById('sox').style.display="none";
//     }
//     if (b.value=='jelighe'){
//         document.getElementById('T-shrt').style.display="none";
//         document.getElementById('Pirhan').style.display="none";
//         document.getElementById('Pants').style.display="none";
//         document.getElementById('underDressman').style.display="none";
//         document.getElementById('fallKoat').style.display="none";
//         document.getElementById('paltoman').style.display="none";
//         document.getElementById('jelighe').style.display="block";
//         document.getElementById('koat').style.display="none";
//         document.getElementById('zhakat').style.display="none";
//         document.getElementById('hodi').style.display="none";
//         document.getElementById('jin').style.display="none";
//         document.getElementById('sox').style.display="none";
//     }
//     if (b.value=='koat'){
//         document.getElementById('T-shrt').style.display="none";
//         document.getElementById('Pirhan').style.display="none";
//         document.getElementById('Pants').style.display="none";
//         document.getElementById('underDressman').style.display="none";
//         document.getElementById('fallKoat').style.display="none";
//         document.getElementById('paltoman').style.display="none";
//         document.getElementById('jelighe').style.display="none";
//         document.getElementById('koat').style.display="block";
//         document.getElementById('zhakat').style.display="none";
//         document.getElementById('hodi').style.display="none";
//         document.getElementById('jin').style.display="none";
//         document.getElementById('sox').style.display="none";
//     }
//     if (b.value=='zhakat'){
//         document.getElementById('T-shrt').style.display="none";
//         document.getElementById('Pirhan').style.display="none";
//         document.getElementById('Pants').style.display="none";
//         document.getElementById('underDressman').style.display="none";
//         document.getElementById('fallKoat').style.display="none";
//         document.getElementById('paltoman').style.display="none";
//         document.getElementById('jelighe').style.display="none";
//         document.getElementById('koat').style.display="none";
//         document.getElementById('zhakat').style.display="block";
//         document.getElementById('hodi').style.display="none";
//         document.getElementById('jin').style.display="none";
//         document.getElementById('sox').style.display="none";
//     }
//     if (b.value=='hodi'){
//         document.getElementById('T-shrt').style.display="none";
//         document.getElementById('Pirhan').style.display="none";
//         document.getElementById('Pants').style.display="none";
//         document.getElementById('underDressman').style.display="none";
//         document.getElementById('fallKoat').style.display="none";
//         document.getElementById('paltoman').style.display="none";
//         document.getElementById('jelighe').style.display="none";
//         document.getElementById('koat').style.display="none";
//         document.getElementById('zhakat').style.display="none";
//         document.getElementById('hodi').style.display="block";
//         document.getElementById('jin').style.display="none";
//         document.getElementById('sox').style.display="none";
//     }
//     if (b.value=='jin'){
//         document.getElementById('T-shrt').style.display="none";
//         document.getElementById('Pirhan').style.display="none";
//         document.getElementById('Pants').style.display="none";
//         document.getElementById('underDressman').style.display="none";
//         document.getElementById('fallKoat').style.display="none";
//         document.getElementById('paltoman').style.display="none";
//         document.getElementById('jelighe').style.display="none";
//         document.getElementById('koat').style.display="none";
//         document.getElementById('zhakat').style.display="none";
//         document.getElementById('hodi').style.display="none";
//         document.getElementById('jin').style.display="block";
//         document.getElementById('sox').style.display="none";
//     }
//     if (b.value=='sox'){
//         document.getElementById('T-shrt').style.display="none";
//         document.getElementById('Pirhan').style.display="none";
//         document.getElementById('Pants').style.display="none";
//         document.getElementById('underDressman').style.display="none";
//         document.getElementById('fallKoat').style.display="none";
//         document.getElementById('paltoman').style.display="none";
//         document.getElementById('jelighe').style.display="none";
//         document.getElementById('koat').style.display="none";
//         document.getElementById('zhakat').style.display="none";
//         document.getElementById('hodi').style.display="none";
//         document.getElementById('jin').style.display="none";
//         document.getElementById('sox').style.display="block";
//     }
//
//
// }
// Edit-for-amir
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
})
$('.fa-times').click(function () {
    $('.bars').css('right','-100%');
})


