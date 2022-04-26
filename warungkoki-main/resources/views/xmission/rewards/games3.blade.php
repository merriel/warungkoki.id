<?php
session_start();
?><!DOCTYPE html>
<html lang="en">
<head>
    <title>TomXperience LOGIN</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->  
    <link rel="icon" type="image/png" href="{{ asset ('assets/icon/72x72.png') }}"/>
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/vendor/bootstrap/css/bootstrap.min.css') }}">

    <link href="{{ asset ('assets/content/css/nav-footer.css') }}" rel="stylesheet" />
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
<!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/vendor/animate/animate.css') }}">
<!--===============================================================================================-->  
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
    <link rel="manifest" href="/manifest.json">
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('assets/splash/css/main.css') }}">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Open+Sans" />
<!--===============================================================================================-->

</head>
<style type="text/css">
    .logo{

        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 1;

    }

    .petugas{

        font-family: Montserrat-Bold;
        font-size: 13px;
        position: absolute;
        bottom: 30px;
        left: 22px;
        z-index: 1;
        color: white;
        width: 100%;
    }


</style>

<style type="text/css">
text{
    font-family:Helvetica, Arial, sans-serif;
    font-size:11px;
    pointer-events:none;
}
#chart{
    position:absolute;
    width:500px;
    height:500px;
    top:0;
    left:0;
    z-index: 9999;
}
#question{
    position: absolute;
    width:400px;
    height:500px;
    top:0;
    left:520px;
}
#question h1{
    font-size: 50px;
    font-weight: bold;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    position: absolute;
    padding: 0;
    margin: 0;
    top:50%;
    -webkit-transform:translate(0,-50%);
            transform:translate(0,-50%);
}
</style>
    
<body>
    <div class="limiter" id="img1">
    	<div class="lotus-login100" style="background-image: url('{{ asset ('assets/splash/images/img-05.jpg') }}');"> 
	    </div>
    </div>
    <div id="chart" style="width: 100%;padding-left: 1rem;"></div>

</body>

    
<!--===============================================================================================-->  
    <script src="{{ asset ('assets/splash/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
    <script src="{{ asset ('assets/splash/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset ('assets/splash/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

<!--===============================================================================================-->
    <script src="{{ asset ('assets/splash/js/main.js') }}"></script>
<!--===============================================================================================-->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="https://d3js.org/d3.v3.min.js" charset="utf-8"></script>
  <script type="text/javascript" charset="utf-8">
      var padding = {top:20, right:40, bottom:0, left:0},
          w = 350 - padding.left - padding.right,
          h = 350 - padding.top  - padding.bottom,
          r = Math.min(w, h)/2,
          rotation = 0,
          oldrotation = 0,
          picked = 100000,
          oldpick = [],
          color = d3.scale.category20();//category20c()
          //randomNumbers = getRandomNumbers();

      //http://osric.com/bingo-card-generator/?title=HTML+and+CSS+BINGO!&words=padding%2Cfont-family%2Ccolor%2Cfont-weight%2Cfont-size%2Cbackground-color%2Cnesting%2Cbottom%2Csans-serif%2Cperiod%2Cpound+sign%2C%EF%B9%A4body%EF%B9%A5%2C%EF%B9%A4ul%EF%B9%A5%2C%EF%B9%A4h1%EF%B9%A5%2Cmargin%2C%3C++%3E%2C{+}%2C%EF%B9%A4p%EF%B9%A5%2C%EF%B9%A4!DOCTYPE+html%EF%B9%A5%2C%EF%B9%A4head%EF%B9%A5%2Ccolon%2C%EF%B9%A4style%EF%B9%A5%2C.html%2CHTML%2CCSS%2CJavaScript%2Cborder&freespace=true&freespaceValue=Web+Design+Master&freespaceRandom=false&width=5&height=5&number=35#results

      $.ajax({
        type: 'GET',
        url: "{{ route('xmission.gethadiah') }}",
        success: function(data) {


        }

      });


      var data = [
                  {"label":"Ultra Teh Kotak Jasmine 200 ml",  "value":1,  "question":"What CSS property is used for specifying the area between the content and its border?"}, // padding
                  {"label":"Ultra Teh Kotak Jasmine 200 ml",  "value":1,  "question":"What CSS property is used for changing the font?"}, //font-family
                  {"label":"Kopiko 78C Coffe Latte 240 ml",  "value":1,  "question":"What CSS property is used for changing the color of text?"}, //color
                  {"label":"Teh Pucuk Harum 350 ml",  "value":1,  "question":"What CSS property is used for changing the boldness of text?"}, //font-weight
                  {"label":"Teh Pucuk Harum 350 ml",  "value":1,  "question":"What CSS property is used for changing the size of text?"}, //font-size
                  {"label":"Kopiko 78C Coffe Latte 240 ml",  "value":1,  "question":"What CSS property is used for changing the background color of a box?"}, //background-color
                  {"label":"Teh Pucuk Harum 350 ml",  "value":1,  "question":"Which word is used for specifying an HTML tag that is inside another tag?"}, //nesting
                  {"label":"Teh Pucuk Harum 350 ml",  "value":1,  "question":"Which side of the box is the third number in: margin:1px 1px 1px 1px; ?"}, //bottom
                  {"label":"Ultra Teh Kotak Jasmine 200 ml",  "value":1,  "question":"What are the fonts that don't have serifs at the ends of letters called?"}, //sans-serif
                  {"label":"Kopiko 78C Coffe Latte 240 ml", "value":1, "question":"With CSS selectors, what character prefix should one use to specify a class?"}, //period
                  
      ];


      var svg = d3.select('#chart')
          .append("svg")
          .data([data])
          .attr("width",  w + padding.left + padding.right)
          .attr("height", h + padding.top + padding.bottom);

      var container = svg.append("g")
          .attr("class", "chartholder")
          .attr("transform", "translate(" + (w/2 + padding.left) + "," + (h/2 + padding.top) + ")");

      var vis = container
          .append("g");
          
      var pie = d3.layout.pie().sort(null).value(function(d){return 1;});

      // declare an arc generator function
      var arc = d3.svg.arc().outerRadius(r);

      // select paths, use arc generator to draw
      var arcs = vis.selectAll("g.slice")
          .data(pie)
          .enter()
          .append("g")
          .attr("class", "slice");
          

      arcs.append("path")
          .attr("fill", function(d, i){ return color(i); })
          .attr("d", function (d) { return arc(d); });

      // add the text
      arcs.append("text").attr("transform", function(d){
              d.innerRadius = 0;
              d.outerRadius = r;
              d.angle = (d.startAngle + d.endAngle)/2;
              return "rotate(" + (d.angle * 180 / Math.PI - 90) + ")translate(" + (d.outerRadius -10) +")";
          })
          .attr("text-anchor", "end")
          .text( function(d, i) {
              return data[i].label;
          });

      container.on("click", spin);


      function spin(d){
          
          container.on("click", null);

          //all slices have been seen, all done
          console.log("OldPick: " + oldpick.length, "Data length: " + data.length);
          if(oldpick.length == data.length){
              console.log("done");
              container.on("click", null);
              return;
          }

          var  ps       = 360/data.length,
               pieslice = Math.round(1440/data.length),
               rng      = Math.floor((Math.random() * 1440) + 360);
              
          rotation = (Math.round(rng / ps) * ps);
          
          picked = Math.round(data.length - (rotation % 360)/ps);
          picked = picked >= data.length ? (picked % data.length) : picked;


          if(oldpick.indexOf(picked) !== -1){
              d3.select(this).call(spin);
              return;
          } else {
              oldpick.push(picked);
          }

          rotation += 90 - Math.round(ps/2);

          vis.transition()
              .duration(3000)
              .attrTween("transform", rotTween)
              .each("end", function(){

                  //mark question as seen
                  d3.select(".slice:nth-child(" + (picked + 1) + ") path")
                      .attr("fill", "#111");

                  //populate question
                  d3.select("#question h1")
                      .text(data[picked].question);

                  oldrotation = rotation;
              
                  container.on("click", spin);
              });
      }

      //make arrow
      svg.append("g")
          .attr("transform", "translate(" + (w + padding.left + padding.right) + "," + ((h/2)+padding.top) + ")")
          .append("path")
          .attr("d", "M-" + (r*.25) + ",0L0," + (r*.05) + "L0,-" + (r*.05) + "Z")
          .style({"fill":"black"});

      //draw spin circle
      container.append("circle")
          .attr("cx", 0)
          .attr("cy", 0)
          .attr("r", 40)
          .style({"fill":"white","cursor":"pointer"});

      //spin text
      container.append("text")
          .attr("x", 0)
          .attr("y", 8)
          .attr("text-anchor", "middle")
          .text("PUTAR")
          .style({"font-weight":"bold", "font-size":"16px"});
      
      
      function rotTween(to) {
        var i = d3.interpolate(oldrotation % 360, rotation);
        return function(t) {
          return "rotate(" + i(t) + ")";
        };
      }
      
      
      function getRandomNumbers(){
          var array = new Uint16Array(1000);
          var scale = d3.scale.linear().range([360, 1440]).domain([0, 100000]);

          if(window.hasOwnProperty("crypto") && typeof window.crypto.getRandomValues === "function"){
              window.crypto.getRandomValues(array);
              console.log("works");
          } else {
              //no support for crypto, get crappy random numbers
              for(var i=0; i < 1000; i++){
                  array[i] = Math.floor(Math.random() * 100000) + 1;
              }
          }

          return array;
      }

  </script>
    

</body>
</html>