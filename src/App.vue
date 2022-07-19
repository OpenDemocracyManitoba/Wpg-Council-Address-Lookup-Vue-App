<template>
  <div>
    <h3>Enter your street address below to find the candidates you will be voting for.</h3>
    <address-auto-complete class="auto-complete" v-on:selected="setAddress"></address-auto-complete>
    <sub>Just the street number and street name, eg: 1 Portage</sub>
    <div v-if="address" class="results">
      <h3>Candidates For {{address}}:</h3>
      <ul>
        <li><a href="/constituencies/mayoral-candidates/"><b>Mayoral</b> Candidates</a></li>
        <li><a :href="council_ward_url"><b>{{ ward }} City Council</b> Candidates</a></li>
        <li><a :href="trustee_ward_url"><b>{{ school_division }} {{school_division_ward }} School Trustee</b> Candidates</a></li>
      </ul>
    </div>
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

  methods: {
    setAddress(data) {
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
      const ward_map = { 'Louis Riel 3': '/constituencies/louis-riel-3/',
        'River East Transcona 3': '/constituencies/river-east-transcona-3/',
        'Pembina Trails 1': '/constituencies/pembina-trails-1/',
        'River East Transcona 2': '/constituencies/river-east-transcona-2/',
        'River East Transcona 1': '/constituencies/river-east-transcona-1/',
        'Winnipeg 6': '/constituencies/winnipeg-6/',
        'St James-Assiniboia Silver Heights-Booth': '/constituencies/st-james-assiniboia-silver-heights-booth/',
        'Pembina Trails 3': '/constituencies/pembina-trails-3/',
        'Seven Oaks 3': '/constituencies/seven-oaks-3/',
        'Louis Riel 1': '/constituencies/louis-riel-1/',
        'River East Transcona 4': '/constituencies/river-east-transcona-4/',
        'Winnipeg 8': '/constituencies/winnipeg-8/',
        'St James-Assiniboia Kirkfield-St Charles': '/constituencies/st-james-assiniboia-kirkfield-st-charles/',
        'Winnipeg 9': '/constituencies/winnipeg-9/',
        'Louis Riel 4': '/constituencies/louis-riel-4/',
        'Winnipeg 7': '/constituencies/winnipeg-7/',
        'St James-Assiniboia King Edward-Deer Lodge': '/constituencies/st-james-assiniboia-king-edward-deer-lodge/',
        'Pembina Trails 2': '/constituencies/pembina-trails-2/',
        'Winnipeg 1': '/constituencies/winnipeg-1/',
        'Seven Oaks 2': '/constituencies/seven-oaks-2/',
        'Winnipeg 5': '/constituencies/winnipeg-5/',
        'Louis Riel 2': '/constituencies/louis-riel-2/',
        'Winnipeg 3': '/constituencies/winnipeg-3/',
        'Seine River ': '/constituencies/seine-river-1/',
        'Winnipeg 2': '/constituencies/winnipeg-2/',
        'Winnipeg 4': '/constituencies/winnipeg-4/' };
      return ward_map[`${this.school_division} ${this.school_division_ward}`];
    }
  }
}
</script>

<style scoped>
  div.results {
    text-align: left;
  }
  .auto-complete {
    margin-top: 1.5rem;
  }
  .results {
    margin-top: 1.5rem;
  }

  ul li {
    margin-left: 1rem;
    margin-top: 0.8rem;
    line-height: 1.2rem;
  }

</style>
