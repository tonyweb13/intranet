import axios from 'axios';
export const API_URL = window.location.origin;
export const PASSPORT_SECRET = 'clear' +
    '';
export const csrf_token = $('meta[name="csrf-token"]').attr('content');

axios.defaults.headers.common['X-CSRF-Token'] = csrf_token;

axios.defaults.validateStatus = function (status) {
    return status >= 200 && status < 425; // default
};

export const TK_API = axios.create({
  baseURL: API_URL+'/api/tk/',
});

export const Dashboard_API = axios.create({
    baseURL: API_URL+'/api/dashboard/',
  });

export const Epic_API = axios.create({
    baseURL: API_URL+'/api/epic/',
});

export const LMS = axios.create({
    baseURL: API_URL+'/api/lms/',
});

export const LoanApp_API = axios.create({
    baseURL: API_URL+'/api/loanapproval/',
});

export const PaymentManager_API = axios.create({
    baseURL: API_URL+'/api/paymentmanager/',
});

export const HR_API = axios.create({
    baseURL: API_URL+'/api/hr/',
});

export const ACTION_API = axios.create({
    baseURL: API_URL+'/api/action/',
});

export const ADMIN_API = axios.create({
    baseURL: API_URL+'/api/admin/',
});

export const TICKET_API = axios.create({
    baseURL: API_URL+'/api/tickets/',
});

export const Settings_API = axios.create({
    baseURL: API_URL+'/api/settings/',
});

export const Vps_API = axios.create({
    baseURL: API_URL+'/api/vps/',
});

export const QA_API = axios.create({
    baseURL: API_URL+'/api/qa/',
});

export const AVERAGE_NUMBER_OF_DAYS_PER_YEAR = 365.2422;
export const AVERAGE_NUMBER_OF_DAYS_PER_MONTH = AVERAGE_NUMBER_OF_DAYS_PER_YEAR / 12;
export const DAYS_PER_WEEK = 7;
export const MIN_DEPOSITS = 2;

export const pay_frequency = [
    {"name":"W","description":"Weekly"},
    {"name":"B","description":"Bi-Weekly"},
    {"name":"S","description":"Semi-Monthly"},
    {"name":"M","description":"Monthly"},
];

export const us_states = [
    {"name":"Alabama","alpha-2":"AL"},
    {"name":"Alaska","alpha-2":"AK"},
    {"name":"Arizona","alpha-2":"AZ"},
    {"name":"Arkansas","alpha-2":"AR"},
    {"name":"California","alpha-2":"CA"},
    {"name":"Colorado","alpha-2":"CO"},
    {"name":"Connecticut","alpha-2":"CT"},
    {"name":"Delaware","alpha-2":"DE"},
    {"name":"District of Columbia","alpha-2":"DC"},
    {"name":"Florida","alpha-2":"FL"},
    {"name":"Georgia","alpha-2":"GA"},
    {"name":"Hawaii","alpha-2":"HI"},
    {"name":"Idaho","alpha-2":"ID"},
    {"name":"Illinois","alpha-2":"IL"},
    {"name":"Indiana","alpha-2":"IN"},
    {"name":"Iowa","alpha-2":"IA"},
    {"name":"Kansa","alpha-2":"KS"},
    {"name":"Kentucky","alpha-2":"KY"},
    {"name":"Lousiana","alpha-2":"LA"},
    {"name":"Maine","alpha-2":"ME"},
    {"name":"Maryland","alpha-2":"MD"},
    {"name":"Massachusetts","alpha-2":"MA"},
    {"name":"Michigan","alpha-2":"MI"},
    {"name":"Minnesota","alpha-2":"MN"},
    {"name":"Mississippi","alpha-2":"MS"},
    {"name":"Missouri","alpha-2":"MO"},
    {"name":"Montana","alpha-2":"MT"},
    {"name":"Nebraska","alpha-2":"NE"},
    {"name":"Nevada","alpha-2":"NV"},
    {"name":"New Hampshire","alpha-2":"NH"},
    {"name":"New Jersey","alpha-2":"NJ"},
    {"name":"New Mexico","alpha-2":"NM"},
    {"name":"New York","alpha-2":"NY"},
    {"name":"North Carolina","alpha-2":"NC"},
    {"name":"North Dakota","alpha-2":"ND"},
    {"name":"Ohio","alpha-2":"OH"},
    {"name":"Oklahoma","alpha-2":"OK"},
    {"name":"Oregon","alpha-2":"OR"},
    {"name":"Pennsylvania","alpha-2":"PA"},
    {"name":"Rhode Island","alpha-2":"RI"},
    {"name":"South Carolina","alpha-2":"SC"},
    {"name":"South Dakota","alpha-2":"SD"},
    {"name":"Tennessee","alpha-2":"TN"},
    {"name":"Texas","alpha-2":"TX"},
    {"name":"Utah","alpha-2":"UT"},
    {"name":"Vermont","alpha-2":"VT"},
    {"name":"Virginia","alpha-2":"VA"},
    {"name":"Washington","alpha-2":"WA"},
    {"name":"West Virginia","alpha-2":"WV"},
    {"name":"Wisconsin","alpha-2":"WI"},
    {"name":"Wyoming","alpha-2":"WY"}
];