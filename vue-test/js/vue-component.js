
Vue.use(VueResource);

Vue.component('navbarcomponent', {
  template: `
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#">TEST</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.html#/test" target="_blank">Question 1 <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="restaurants.html target="_blank"">Restaurants in Bangsue</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cv.html" target="_blank">My CV</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="http://phpstack-312963-958621.cloudwaysapps.com/scg-test/public/" target="_blank">Zend Test</a>
        </li>                
      </ul>
    </div>
  </nav>
  `
});


Vue.component('footercomponent', {
  template: `<footer class="footer">
        <div class="container">
          <span>Footer</span>
        </div>
      </footer>`
});


var vm = new Vue({
  el: '#component_test'
});


// route 
const question1Route = {

  template: `<div class="container">
     <div class="card">
  <div class="card-header">
  <b>Question 1 :</b> 3, 5, 9, 15, X,Y,Z  - Please create new function for finding X,Y,Z value.
  </div>
  <div class="card-body">
    <p class="card-text">{{ startData }}</p>
    <a href="#" class="btn btn-primary" v-on:click="getNextValue" >Next</a>
  </div>
</div>
     </div>
     </div>
     `,
  data: function () {
    return {
      startData: this.startDataFuntion(),
      nextData: null
    }
  },
  methods: {

    startDataFuntion: function () {

      if (localStorage.getItem("question1") != null) {

        return this.startData = JSON.parse('[' + localStorage.getItem("question1") + ']');
      }
      return [3, 5, 9, 15];
    },
    getNextValue: function () {
      currentData = this.startData;
      this.startData = this.findNextAlphabet(currentData);
      this.nextData = this.startData;
      localStorage.setItem('question1', this.startData);

    },
    findNextAlphabet: function (currentData) {
      sizeOfArray = currentData.length;
      lastvalue = currentData[sizeOfArray - 1];
      nextValue = (sizeOfArray * 2) + lastvalue;
      currentData.push(nextValue)
      return currentData;

    }
  }

}


const routes = [
  { path: '/scg', component: question1Route },
];

const router = new VueRouter({
  routes // short for `routes: routes`
});

var view = new Vue({
  el: '#view',
  router
});

// default route
router.replace('/scg');


var restaurants = new Vue({

  el: '#restaurantslist',
  data: {

    htmlcontent: '',
    restaurantObj: ''

  },
  computed: {

    getData: function () {


      if (localStorage.getItem("restObj") === null) {

        this.$http.get('http://phpstack-312963-958621.cloudwaysapps.com/scg-test/public/test/getrestaurant').then(function (response) {

          if (response.status == "200") {
            this.restaurantObj = response.data.results;
          }

          localStorage.setItem("restObj", JSON.stringify(this.restaurantObj));
          /*
              object propeties : formatted_address,name,rating,icon
          */
        });
      }

      this.restaurantObj = localStorage.getItem("restObj");
      this.restaurantObj = JSON.parse(this.restaurantObj);

      for (key in this.restaurantObj) {

        card = `<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">`+ this.restaurantObj[key].name + `</h5>
    <p class="card-text">`+ this.restaurantObj[key].formatted_address + `</p>
    <p>Rating: `+ this.restaurantObj[key].rating + `</p>
  </div>
</div>`;

        this.htmlcontent += card;
      }
    }
  }

});

new Vue({
  el: '#chart',
  data: {
    test: '',
  },
  computed: {
    showChart: function(){
      console.log('Test');
    }
  }
})




