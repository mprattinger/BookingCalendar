// @ts-check

class MprBookingcalendarClient {
  constructor() {
    this.parentDiv = document.getElementsByClassName('mpr-bc-table')[0];
    if (this.parentDiv == null) return;

    const currentDate = new Date();
    this.currentMonth = currentDate.getMonth() + 1;
    this.currentYear = currentDate.getFullYear();

    this.buildYearSelector();
    this.setValues();

    this.setEvents();

    this.buildCalendar();
  }

  async buildCalendar() {
    const first = this.getFirstDay();
    const last = this.getLastDay();

    let child = this.parentDiv.lastElementChild;
    while (child && !child.classList.contains('mpr-bc-header')) {
      this.parentDiv.removeChild(child);
      child = this.parentDiv.lastElementChild;
    }

    const bookings = await this.callWebService();
    const bookedDays = this.getBookedDays(bookings);

    // eslint-disable-next-line no-unmodified-loop-condition
    for (let curr = first; curr < last; curr.setDate(curr.getDate() + 1)) {
      const itm = this.buildDayItem(curr, bookedDays);
      this.parentDiv.appendChild(itm);
    }
  }

  setEvents() {
    this.prevToggler = document.getElementById('mpr-bc-toggler-prev');
    this.nextToggler = document.getElementById('mpr-bc-toggler-next');
    const yearSelector = document.getElementById('mpr-bc-selector-year');
    const monthSelector = document.getElementById('mpr-bc-selector-month');

    this.prevToggler.addEventListener('click', () => {
      this.currentMonth--;
      if (this.currentMonth < 1) {
        this.currentMonth = 12;
        this.currentYear--;
      }
      this.buildCalendar();
      this.setValues();
    });
    this.nextToggler.addEventListener('click', () => {
      this.currentMonth++;
      if (this.currentMonth > 12) {
        this.currentMonth = 1;
        this.currentYear++;
      }
      this.buildCalendar();
      this.setValues();
    });

    yearSelector.addEventListener('change', (el, evt) => {
      this.currentYear = parseInt(evt.target.value);
      this.buildCalendar();
    });
    monthSelector.addEventListener('change', (el, evt) => {
      this.currentMonth = parseInt(evt.target.value);
      this.buildCalendar();
    });
  }

  buildDayItem(theDate, /** @type {Array} */bookedDays) {
    const itm = document.createElement('div');
    if(bookedDays.includes(theDate.getDate().toString() + (theDate.getMonth() + 1).toString())) itm.setAttribute('class', 'mpr-bc-cell booked');
    else itm.setAttribute('class', 'mpr-bc-cell free');
    itm.innerText = theDate.getDate();
    return itm;
  }

  getFirstDay() {
    const first = new Date(this.currentYear, this.currentMonth - 1, 1);
    while (first.getDay() !== 1) {
      first.setDate(first.getDate() - 1);
    }
    return first;
  }

  getLastDay() {
    const last = new Date(this.currentYear, this.currentMonth, 1);
    last.setDate(last.getDate() - 1);
    while (last.getDay() !== 0) {
      last.setDate(last.getDate() + 1);
    }
    last.setDate(last.getDate() + 1);
    return last;
  }

  buildYearSelector() {
    const yearSelector = document.getElementById('mpr-bc-selector-year');
    const currentDate = new Date();
    const start = currentDate.getFullYear() - 1;
    const end = start + 20;

    for (let i = start; i <= end; i++) {
      const opt = document.createElement('option');
      opt.value = i.toString();
      opt.innerText = i.toString();
      yearSelector.appendChild(opt);
    }
  }

  setValues() {
    const yearSelector = /** @type {HTMLSelectElement} */ (document.getElementById('mpr-bc-selector-year'));
    const monthSelector = /** @type {HTMLSelectElement} */ (document.getElementById('mpr-bc-selector-month'));

    monthSelector.value = this.currentMonth.toString();
    yearSelector.value = this.currentYear.toString();
  }

  callWebService() {
    return new Promise((resolve, reject) => {
      const xhr = new XMLHttpRequest();
      xhr.onload = () => {
        if (xhr.status >= 200 && xhr.status < 300) {
          const data = JSON.parse(xhr.responseText);
          console.log('sucess: ' + xhr.responseText, xhr);
          resolve(data);
        } else {
          console.error(`Error ${xhr.status}`);
          reject(new Error(`Error ${xhr.status}`));
        }
      };

      const first = this.getFirstDay();
      const last = this.getLastDay();
      // @ts-ignore
      xhr.open('GET', window.mprbcData.endpoint + '/bcdata?starting=' + this.formatDate(first) + '&ending=' + this.formatDate(last));
      // xhr.setRequestHeader('X-WP-Nonce', mprbcData.nonces.wp_rest);
      xhr.send();
    });
  }

  getBookedDays(bookings) {
    const ret = [];
    for(let i = 0; i < bookings.length; i++) {
      const b = bookings[i];
      const starting = new Date(b.starting);
      const ending = new Date(b.ending);
      // eslint-disable-next-line no-unmodified-loop-condition
      while(starting <= ending) {
        ret.push(starting.getDate().toString() + (starting.getMonth() + 1).toString());
        starting.setDate(starting.getDate() + 1);
      }
    }
    return ret;
  }

  formatDate(theDate) {
    let dd = theDate.getDate();
    let mm = theDate.getMonth() + 1;

    const yyyy = theDate.getFullYear();
    if (dd < 10) {
      dd = '0' + dd;
    }
    if (mm < 10) {
      mm = '0' + mm;
    }
    return yyyy + '-' + mm + '-' + dd;
  }
}

// eslint-disable-next-line no-unused-vars
const mprBookingCalendar = new MprBookingcalendarClient();
