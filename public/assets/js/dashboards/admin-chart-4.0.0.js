document.addEventListener("DOMContentLoaded", () => {
  $.ajax({
      type : "GET",
      url  : "/students-count-by-age",
      success: function (response) { 
        let age_7 = response[0].age_7;
        let age_8 = response[0].age_8;
        let age_9 = response[0].age_9;
        let age_10 = response[0].age_10;
        let age_11 = response[0].age_11;
        let age_12 = response[0].age_12;
        let age_13 = response[0].age_13;
        let age_14 = response[0].age_14;

        var age_options = {
          series: [age_7, age_8, age_9, age_10, age_11, age_12, age_13, age_14],
          chart: {
            fontFamily: '"Nunito Sans", sans-serif',
            width: 380,
            type: "pie",
          },
          colors: ["var(--bs-primary)", "var(--bs-secondary)", "#ffae1f", "#fa896b", "#39b69a"],
          labels: ['Age Seven', 'Age Eight', 'Age Nine', 'Age Ten', 'Age Eleven', 'Age Twelve', 'Age Thirteen', 'Age Fourteen'],
          responsive: [{
            breakpoint: 480,
            options: {
              chart: {
                width: 200,
              },
              legend: {
                position: "bottom",
              },
            },
          }, ],
          legend: {
            labels: {
              colors: ["#a1aab2"],
            },
          },
        };
        var reg_by_age_pie = new ApexCharts(
          document.querySelector("#registration_by_age_chart_pie"),
          age_options
        );
        reg_by_age_pie.render();
      },
      error: function (response){
          console.log('fail');
      }
  });

  $.ajax({
    type : "GET",
    url  : "/students-count-by-gender",
    success: function (response) { 
      let male = response[0].male;
      let female = response[0].female;

      var gender_options = {
        series: [male, female],
        chart: {
          fontFamily: '"Nunito Sans", sans-serif',
          width: 380,
          type: "pie",
        },
        colors: ["var(--bs-primary)", "var(--bs-secondary)", "#ffae1f", "#fa896b", "#39b69a"],
        labels: ['Boys', 'Girls'],
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200,
            },
            legend: {
              position: "bottom",
            },
          },
        }, ],
        legend: {
          labels: {
            colors: ["#a1aab2"],
          },
        },
      };
      var reg_by_gender_pie = new ApexCharts(
        document.querySelector("#registration_by_gender_chart_pie"),
        gender_options
      );
      reg_by_gender_pie.render();
    },
    error: function (response){
        console.log('fail');
    }
  });

  $.ajax({
    type : "GET",
    url  : "/students-count-by-country",
    success: function (response) { 
      let number_of_countries = [];
      let names_of_countries = [];
      
      $.each(response, function( index, value ) {
        names_of_countries[index] = value.country;
        number_of_countries[index] = value.registrations;
      })
      var country_option = {
        series: [
          {
            data: number_of_countries,
          },
        ],
        chart: {
          fontFamily: '"Nunito Sans", sans-serif',
          type: "bar",
          height: 350,
          toolbar: {
            show: false,
          },
        },
        grid: {
          borderColor: "transparent",
        },
        colors: ["var(--bs-primary)"],
        plotOptions: {
          bar: {
            horizontal: true,
          },
        },
        dataLabels: {
          enabled: false,
        },
        xaxis: {
          categories: [
            names_of_countries[0],names_of_countries[1],names_of_countries[2],names_of_countries[3],names_of_countries[4]
          ],
          labels: {
            style: {
              colors: [
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
              ],
            },
          },
        },
        yaxis: {
          labels: {
            style: {
              colors: [
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
                "#a1aab2",
              ],
            },
          },
        },
        tooltip: {
          theme: "dark",
        },
      };
    
      var reg_by_country_bar = new ApexCharts(
        document.querySelector("#registration_by_country_chart_bar"),
        country_option
      );
      reg_by_country_bar.render();
    },
    error: function (data){
        console.log('fail');
    }
  });
  $.ajax({
    type : "GET",
    url  : "/students-count-by-teacher",
    success: function (response) { 
        let html = '';
        if(response.length >0){
            $.each(response, function(index, value){
                html+= `<tr><td>${value.Teacher}</td><td>${value.Active}</td><td>${value.Terminated}</td></tr>`;
            })
            $('#teacher_table').html(html)
        }   
    },
    error: function (data){
        console.log('fail');
    }
});
    
});