var stateGroups = {
	activeState: null,
	groups: {
		'AL' : 'https://groups.google.com/d/forum/teamlessigAL',
		'AK' : 'https://groups.google.com/d/forum/teamlessigAK',
		'AZ' : 'https://groups.google.com/d/forum/teamlessigAZ',
		'AR' : 'https://groups.google.com/d/forum/teamlessigAR',
		'CA' : 'https://groups.google.com/d/forum/teamlessigCA',
		'CO' : 'https://groups.google.com/d/forum/teamlessigCO',
		'CT' : 'https://groups.google.com/d/forum/teamlessigCT',
		'DE' : 'https://groups.google.com/d/forum/teamlessigDE',
		'FL' : 'https://groups.google.com/d/forum/teamlessigFL',
		'GA' : 'https://groups.google.com/d/forum/teamlessigGA',
		'HI' : 'https://groups.google.com/d/forum/teamlessigHI',
		'ID' : 'https://groups.google.com/d/forum/teamlessigID',
		'IL' : 'https://groups.google.com/d/forum/teamlessigIL',
		'IN' : 'https://groups.google.com/d/forum/teamlessigIN',
		'IA' : 'https://groups.google.com/d/forum/teamlessigIA',
		'KS' : 'https://groups.google.com/d/forum/teamlessigKS',
		'KY' : 'https://groups.google.com/d/forum/teamlessigKY',
		'LA' : 'https://groups.google.com/d/forum/teamlessigLA',
		'ME' : 'https://groups.google.com/d/forum/teamlessigME',
		'MD' : 'https://groups.google.com/d/forum/teamlessigMD',
		'MA' : 'https://groups.google.com/d/forum/teamlessigMA',
		'MI' : 'https://groups.google.com/d/forum/teamlessigMI',
		'MN' : 'https://groups.google.com/d/forum/teamlessigMN',
		'MS' : 'https://groups.google.com/d/forum/teamlessigMS',
		'MO' : 'https://groups.google.com/d/forum/teamlessigMO',
		'MT' : 'https://groups.google.com/d/forum/teamlessigMT',
		'NE' : 'https://groups.google.com/d/forum/teamlessigNE',
		'NV' : 'https://groups.google.com/d/forum/teamlessigNV',
		'NH' : 'https://groups.google.com/d/forum/teamlessigNH',
		'NJ' : 'https://groups.google.com/d/forum/teamlessigNJ',
		'NM' : 'https://groups.google.com/d/forum/teamlessigNM',
		'NY' : 'https://groups.google.com/d/forum/teamlessigNY',
		'NC' : 'https://groups.google.com/d/forum/teamlessigNC',
		'ND' : 'https://groups.google.com/d/forum/teamlessigND',
		'OH' : 'https://groups.google.com/d/forum/teamlessigOH',
		'OK' : 'https://groups.google.com/d/forum/teamlessigOK',
		'OR' : 'https://groups.google.com/d/forum/teamlessigOR',
		'PA' : 'https://groups.google.com/d/forum/teamlessigPA',
		'PR' : 'https://groups.google.com/d/forum/teamlessigPR',
		'RI' : 'https://groups.google.com/d/forum/teamlessigRI',
		'SC' : 'https://groups.google.com/d/forum/teamlessigSC',
		'SD' : 'https://groups.google.com/d/forum/teamlessigSD',
		'TN' : 'https://groups.google.com/d/forum/teamlessigTN',
		'TX' : 'https://groups.google.com/d/forum/teamlessigTX',
		'UT' : 'https://groups.google.com/d/forum/teamlessigUT',
		'VA' : 'https://groups.google.com/d/forum/teamlessigVA',
		'WA' : 'https://groups.google.com/d/forum/teamlessigWA',
		'WV' : 'https://groups.google.com/d/forum/teamlessigWV',
		'WI' : 'https://groups.google.com/d/forum/teamlessigWI',
		'WY' : 'https://groups.google.com/d/forum/teamlessigWY',	//others
		'AS' : 'https://groups.google.com/d/forum/teamlessigAS',
		'DC' : 'https://groups.google.com/d/forum/teamlessigDC',
		'GU' : 'https://groups.google.com/d/forum/teamlessigGU',
		'APO' : 'https://groups.google.com/d/forum/teamlessigAPO',
		'CM' : 'https://groups.google.com/d/forum/teamlessigCM',
		'PR' : 'https://groups.google.com/d/forum/teamlessigPR',
		'VI' : 'https://groups.google.com/d/forum/teamlessigVI',
		'DA' : 'https://groups.google.com/d/forum/teamlessigWorldwide',
	},
	states_hash: {
    'Alabama': 'AL',
    'Alaska': 'AK',
    'American Samoa': 'AS',
    'Arizona': 'AZ',
    'Arkansas': 'AR',
    'California': 'CA',
    'Colorado': 'CO',
    'Connecticut': 'CT',
    'Delaware': 'DE',
    'District of Columbia': 'DC',
    'Federated States Of Micronesia': 'FM',
    'Florida': 'FL',
    'Georgia': 'GA',
    'Guam': 'GU',
    'Hawaii': 'HI',
    'Idaho': 'ID',
    'Illinois': 'IL',
    'Indiana': 'IN',
    'Iowa': 'IA',
    'Kansas': 'KS',
    'Kentucky': 'KY',
    'Louisiana': 'LA',
    'Maine': 'ME',
    'Marshall Islands': 'MH',
    'Maryland': 'MD',
    'Massachusetts': 'MA',
    'Michigan': 'MI',
    'Minnesota': 'MN',
    'Mississippi': 'MS',
    'Missouri': 'MO',
    'Montana': 'MT',
    'Nebraska': 'NE',
    'Nevada': 'NV',
    'New Hampshire': 'NH',
    'New Jersey': 'NJ',
    'New Mexico': 'NM',
    'New York': 'NY',
    'North Carolina': 'NC',
    'North Dakota': 'ND',
    'Northern Mariana Islands': 'CM',
    'Ohio': 'OH',
    'Oklahoma': 'OK',
    'Oregon': 'OR',
    'Palau': 'PW',
    'Pennsylvania': 'PA',
    'Puerto Rico': 'PR',
    'Rhode Island': 'RI',
    'South Carolina': 'SC',
    'South Dakota': 'SD',
    'Tennessee': 'TN',
    'Texas': 'TX',
    'Utah': 'UT',
    'Vermont': 'VT',
    'U.S. Virgin Islands': 'VI',
    'Virginia': 'VA',
    'Washington': 'WA',
    'West Virginia': 'WV',
    'Wisconsin': 'WI',
    'Wyoming': 'WY',
    'Military Families (APO)': 'APO',
    'Democrats Abroad': 'DA'
  }
};


var sendToGoogle = function(gLink){
	window.open(gLink);
};

var showVolunteerForm = function(){
	$('#volunteer-signup-section').fadeIn();
};

jQuery(function(){
if($('#vmap').length) {

$('#vmap').vectorMap({
    map: 'usa_en',
    backgroundColor: '#ffffff',
    color: '#3d55e7',
    hoverColor: '#1831cb',
    selectedColor: '#ff4e4e',
    enableZoom: false,
    showTooltip: true,
    onRegionClick: function(element, code, region)
    {
	console.log(code);
        console.log(region);
	var stateAbbrev = code.toUpperCase();
	var stateLink = stateGroups.groups[stateAbbrev] || false;
	stateGroups.activeState = stateAbbrev;
	if(!stateLink){
		
		console.log('missing ' + stateAbbrev + ' group link');
	}else{
		//window.open(stateLink);
	}
	$('#volunteer-box').hide();
	showVolunteerForm();
	window.scrollTo(0,0);
	//var region_url = 'https://lessig2016.us/region/' + region;
	
    }
  });
  }

	$('#select-region').change(function(){
		var regAbbrev = $(this).val();
		stateGroups.activeState = regAbbrev;
		var gLink =  stateGroups.groups[regAbbrev];
		console.log(regAbbrev);
		$('#volunteer-box').hide();
		showVolunteerForm();
		//window.open(gLink);
		window.scrollTo(0,0);	
	});

	$('#volunteer-box  td  a').click(function(e){
		e.preventDefault();
		var fStateName = $(this).text();
		var fStateAbbrev = stateGroups.states_hash[fStateName];
		console.log(fStateAbbrev);
		stateGroups.activeState = fStateAbbrev;
		var gLink =  stateGroups.groups[fStateAbbrev];
		//window.open(gLink);
		$('#volunteer-box').hide();
		showVolunteerForm();
		window.scrollTo(0,0);
	});

	$('#volunteerSkipButton').click(function(){
		var stateLink = stateGroups.activeState;
		sendToGoogle( stateGroups.groups[stateLink] );
	});
});
