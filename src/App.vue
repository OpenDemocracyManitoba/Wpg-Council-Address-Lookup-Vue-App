<template>
  <div>
    <h3>Find your Candidates</h3>
    <p>Enter your street address below to find the candidates you will be voting for.</p>
    <address-auto-complete class="auto-complete" v-on:selected="setAddress"></address-auto-complete>
    <sub>Just street number and street name, eg: 1 Portage</sub>
    <div v-if="address" class="results">
      <p><strong>Address:</strong> {{ address }}</p>
      <p><strong>Ward:</strong> {{ ward }}</p>
      <p><strong>School Division:</strong> {{ school_division }} {{ school_division_ward }}</p>
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
      const ward_map = { 'St. Vital': 'https://www.winnipegelection.ca/constituencies/st-vital/',
        'Elmwood - East Kildonan': 'https://www.winnipegelection.ca/constituencies/elmwood-east-kildonan/',
        'Charleswood - Tuxedo': 'https://www.winnipegelection.ca/constituencies/charleswood-tuxedo/',
        'Transcona': 'https://www.winnipegelection.ca/constituencies/transcona/',
        'Daniel McIntyre': 'https://www.winnipegelection.ca/constituencies/daniel-mcintyre/',
        'St. James': 'https://www.winnipegelection.ca/constituencies/st-james/',
        'Waverley West': 'https://www.winnipegelection.ca/constituencies/waverley-west/',
        'Old Kildonan': 'https://www.winnipegelection.ca/constituencies/old-kildonan/',
        'St. Boniface': 'https://www.winnipegelection.ca/constituencies/st-boniface/',
        'North Kildonan': 'https://www.winnipegelection.ca/constituencies/north-kildonan/',
        'Mynarski': 'https://www.winnipegelection.ca/constituencies/mynarski/',
        'Point Douglas': 'https://www.winnipegelection.ca/constituencies/point-douglas/',
        'River Heights - Fort Garry': 'https://www.winnipegelection.ca/constituencies/river-heights-fort-garry/',
        'St. Norbert - Seine River': 'https://www.winnipegelection.ca/constituencies/st-norbert-seine-river/',
        'Fort Rouge - East Fort Garry': 'https://www.winnipegelection.ca/constituencies/fort-rouge-east-fort-garry/' };
      return ward_map[this.ward];
    },

    trustee_ward_url() {
      const ward_map = { 'Louis Riel 3': 'https://www.winnipegelection.ca/constituencies/louis-riel-3/',
        'River East Transcona 3': 'https://www.winnipegelection.ca/constituencies/river-east-transcona-3/',
        'Pembina Trails 1': 'https://www.winnipegelection.ca/constituencies/pembina-trails-1/',
        'River East Transcona 2': 'https://www.winnipegelection.ca/constituencies/river-east-transcona-2/',
        'River East Transcona 1': 'https://www.winnipegelection.ca/constituencies/river-east-transcona-1/',
        'Winnipeg 6': 'https://www.winnipegelection.ca/constituencies/winnipeg-6/',
        'St James-Assiniboia Silver Heights-Booth': 'https://www.winnipegelection.ca/constituencies/st-james-assiniboia-silver-heights-booth/',
        'Pembina Trails 3': 'https://www.winnipegelection.ca/constituencies/pembina-trails-3/',
        'Seven Oaks 3': 'https://www.winnipegelection.ca/constituencies/seven-oaks-3/',
        'Louis Riel 1': 'https://www.winnipegelection.ca/constituencies/louis-riel-1/',
        'River East Transcona 4': 'https://www.winnipegelection.ca/constituencies/river-east-transcona-4/',
        'Winnipeg 8': 'https://www.winnipegelection.ca/constituencies/winnipeg-8/',
        'St James-Assiniboia Kirkfield-St Charles': 'https://www.winnipegelection.ca/constituencies/st-james-assiniboia-kirkfield-st-charles/',
        'Winnipeg 9': 'https://www.winnipegelection.ca/constituencies/winnipeg-9/',
        'Louis Riel 4': 'https://www.winnipegelection.ca/constituencies/louis-riel-4/',
        'Winnipeg 7': 'https://www.winnipegelection.ca/constituencies/winnipeg-7/',
        'St James-Assiniboia King Edward-Deer Lodge': 'https://www.winnipegelection.ca/constituencies/st-james-assiniboia-king-edward-deer-lodge/',
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
  div.results {
    text-align: left;
  }
  .auto-complete {
    margin-top: 1.5em;
  }
  .results {
    margin-top: 1.5em;
  }

</style>
