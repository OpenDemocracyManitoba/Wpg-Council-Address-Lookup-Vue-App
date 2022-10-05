<template>
  <div>
    <h1>Search Your Address to Find Your Candidates</h1>
    <address-auto-complete class="auto-complete" v-on:selected="setAddress"></address-auto-complete>
    <div v-if="address" class="results">
      <h2>Candidates For <span class="yes">{{address}}</span> <a @click="clear">(clear)</a></h2>
      <ul>
        <li><a href="/constituencies/mayoral-candidates/"><b>Mayoral</b> Candidates</a></li>
        <li><a :href="council_ward_url"><b>{{ ward }} City Council</b> Candidates</a></li>
        <li><a :href="trustee_ward_url"><b>{{ school_division }} {{school_division_ward }} School Trustee</b> Candidates</a></li>
      </ul>
    </div>
    <sub v-else><b>Address Not Found?</b> Please don't include street type (st, pl, dr, street, place, etc). &nbsp; <b class="yes">Correct Search:</b> 1 Portage &nbsp; <b class="no">Incorrect Search:</b> 1 Portage <span class="no">Ave</span></sub>
  </div>
</template>

<script>
import AddressAutoComplete from './components/AddressAutoComplete.vue'

export default {
  name: 'App',
  components: {
    AddressAutoComplete,
  },

  data() {
    return {
      address: null,
      ward: null,
      school_division: null,
      school_division_ward: null,
      selected_results: null,
    }
  },

  created() {
    if (localStorage && localStorage.results) {
      this.setAddress(JSON.parse(localStorage.results));
    }
  },

  methods: {
    clear() {
      if (localStorage && localStorage.results) {
        localStorage.clear();
      }
      this.address = null;
      this.ward = null;
      this.school_division_ward = null;
      this.school_division = null;
      this.selected_results = null;
    },

    setAddress(data) {
      if (localStorage) {
        localStorage.setItem("results",JSON.stringify(data));
      }
      this.ward = data.ward;
      this.school_division = data.school_division;
      this.school_division_ward = data.school_division_ward;
      this.address = data.address;
      this.selected_results = data;
    }
  },

  computed: {
    council_ward_url() {
      const ward_map = { 'St. Vital': '/constituencies/st-vital/',
        'Elmwood - East Kildonan': '/constituencies/elmwood-east-kildonan/',
        'Charleswood - Tuxedo': '/constituencies/charleswood-tuxedo/',
        'Transcona': '/constituencies/transcona/',
        'Daniel McIntyre': '/constituencies/daniel-mcintyre/',
        'St. James': '/constituencies/st-james/',
        'Waverley West': '/constituencies/waverley-west/',
        'Old Kildonan': '/constituencies/old-kildonan/',
        'St. Boniface': '/constituencies/st-boniface/',
        'North Kildonan': '/constituencies/north-kildonan/',
        'Mynarski': '/constituencies/mynarski/',
        'Point Douglas': '/constituencies/point-douglas/',
        'River Heights - Fort Garry': '/constituencies/river-heights-fort-garry/',
        'St. Norbert - Seine River': '/constituencies/st-norbert-seine-river/',
        'Fort Rouge - East Fort Garry': '/constituencies/fort-rouge-east-fort-garry/' };
      return ward_map[this.ward];
    },

    trustee_ward_url() {
      const ward_map = { 'Louis Riel 3': 'https://www.winnipegelection.ca/constituencies/louis-riel-3/',
    'River East - Transcona 3': 'https://www.winnipegelection.ca/constituencies/river-east-transcona-3/',
    'Pembina Trails 1': 'https://www.winnipegelection.ca/constituencies/pembina-trails-1/',
    'River East - Transcona 2': 'https://www.winnipegelection.ca/constituencies/river-east-transcona-2/',
    'River East - Transcona 1': 'https://www.winnipegelection.ca/constituencies/river-east-transcona-1/',
    'Winnipeg 6': 'https://www.winnipegelection.ca/constituencies/winnipeg-6/',
    'St James-Assiniboia Centre Ward': 'https://www.winnipegelection.ca/constituencies/st-james-assiniboia-centre-ward/',
    'Pembina Trails 3': 'https://www.winnipegelection.ca/constituencies/pembina-trails-3/',
    'Seven Oaks 3': 'https://www.winnipegelection.ca/constituencies/seven-oaks-3/',
    'Louis Riel 1': 'https://www.winnipegelection.ca/constituencies/louis-riel-1/',
    'River East - Transcona 4': 'https://www.winnipegelection.ca/constituencies/river-east-transcona-4/',
    'Winnipeg 8': 'https://www.winnipegelection.ca/constituencies/winnipeg-8/',
    'St James-Assiniboia West Ward': 'https://www.winnipegelection.ca/constituencies/st-james-assiniboia-west-ward/',
    'Winnipeg 9': 'https://www.winnipegelection.ca/constituencies/winnipeg-9/',
    'Louis Riel 4': 'https://www.winnipegelection.ca/constituencies/louis-riel-4/',
    'Winnipeg 7': 'https://www.winnipegelection.ca/constituencies/winnipeg-7/',
    'St James-Assiniboia East Ward': 'https://www.winnipegelection.ca/constituencies/st-james-assiniboia-east-ward/',
    'Pembina Trails 2': 'https://www.winnipegelection.ca/constituencies/pembina-trails-2/',
    'Winnipeg 1': 'https://www.winnipegelection.ca/constituencies/winnipeg-1/',
    'Seven Oaks 2': 'https://www.winnipegelection.ca/constituencies/seven-oaks-2/',
    'Winnipeg 5': 'https://www.winnipegelection.ca/constituencies/winnipeg-5/',
    'Louis Riel 2': 'https://www.winnipegelection.ca/constituencies/louis-riel-2/',
    'Winnipeg 3': 'https://www.winnipegelection.ca/constituencies/winnipeg-3/',
    'Seine River ': 'https://www.winnipegelection.ca/constituencies/seine-river-1/',
    'Winnipeg 2': 'https://www.winnipegelection.ca/constituencies/winnipeg-2/',
    'Winnipeg 4': 'https://www.winnipegelection.ca/constituencies/winnipeg-4/' };
      return ward_map[`${this.school_division} ${this.school_division_ward}`];
    }
  }
}
</script>

<style scoped>
  a {
    cursor: pointer;
  }
  div.results {
    text-align: left;
  }
  .auto-complete {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
  }
  .results {
    margin-top: 1.5rem;
  }

  ul li {
    margin-left: 1rem;
    margin-top: 1rem;
    font-size: 1.1rem;
    line-height: 1.2;
  }

  .yes {
    color: green;
  }

  b.no {
    color: #bb4040;
  }

  span.no {
    border-bottom: 2px solid #bb4040;
  }

  sub {
    line-height: 1.4;
  }

  h1, h2 {
    margin-left: 0;
  }

</style>
