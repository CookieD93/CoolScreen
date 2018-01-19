function nightModeStyle(){
    var Clock=new Date()
    var hours=Clock.getHours()
    var min=Clock.getMinutes()
    var sec = Clock.getSeconds()
    if(hours>=7&&hours<=19)//min%2 == 1
    {
        document.getElementById("nightModeStyle").href="assets/bgstyle-day.css";
    }
    else
    {        
        document.getElementById("nightModeStyle").href="assets/bgstyle-night.css";
    }
    var t = setTimeout(nightModeStyle, 500);
}



//  function nightModeStyle(){
//     var Clock=new Date()
//     var hours=Clock.getHours()
//     var min=Clock.getMinutes()
//     var sec = Clock.getSeconds()


//     if(sec>0 && sec<30){

//         document.write('<link rel="stylesheet" href="assets/bgstyle-night.css">');
//     }
//     else
//     {
//         document.write('<link rel="stylesheet" href="assets/bgstyle-day.css">');
//     }
//     var t = setTimeout(nightModeStyle, 10000);

// }


// if (hours>=7&&hours<=19)
// { 
//     // document.write('<link rel="stylesheet" href="assets/bgstyle-day.css">');
//     document.write('<link rel="stylesheet" href="assets/bgstyle-night.css">');

// }
// else
// {
//     document.write('<link rel="stylesheet" href="assets/bgstyle-day.css">');
//     // document.write('<link rel="stylesheet" href="assets/bgstyle-night.css">');
// }

