class MPR_Bookingcalendar_Client {

    constructor() {
        this.parentDiv = document.getElementsByClassName("mpr-bc-table")[0];
        if (this.parentDiv == null) return;

        let currentDate = new Date();
        this.currentMonth = currentDate.getMonth() + 1;
        this.currentYear = currentDate.getFullYear();

        this.buildYearSelector();
        this.setValues();

        this.setEvents();

        this.buildCalendar();
    }

    buildCalendar() {
        let first = this.getFirstDay();
        let last = this.getLastDay();

        var child = this.parentDiv.lastElementChild;
        while (child && !child.classList.contains("mpr-bc-header")) {
            this.parentDiv.removeChild(child);
            child = this.parentDiv.lastElementChild;
        }

        for (var curr = first; curr < last; first.setDate(first.getDate() + 1)) {
            let itm = this.buildDayItem(curr);
            this.parentDiv.appendChild(itm);
        }

        this.callWebService();
    }

    setEvents() {
        this.prevToggler = document.getElementById("mpr-bc-toggler-prev");
        this.nextToggler = document.getElementById("mpr-bc-toggler-next")
        let yearSelector = document.getElementById("mpr-bc-selector-year");
        let monthSelector = document.getElementById("mpr-bc-selector-month");

        this.prevToggler.addEventListener("click", () => {
            this.currentMonth--;
            if (this.currentMonth < 1) {
                this.currentMonth = 12;
                this.currentYear--;
            }
            this.buildCalendar();
            this.setValues();
        });
        this.nextToggler.addEventListener("click", () => {
            this.currentMonth++;
            if (this.currentMonth > 12) {
                this.currentMonth = 1;
                this.currentYear++;
            }
            this.buildCalendar();
            this.setValues();
        })

        yearSelector.addEventListener("change", (evt) => {
            this.currentYear = parseInt(evt.target.value);
            this.buildCalendar();
        });
        monthSelector.addEventListener("change", (evt) => {
            this.currentMonth = parseInt(evt.target.value);
            this.buildCalendar();
        });
    }

    buildDayItem(theDate) {
        let itm = document.createElement("div");
        itm.setAttribute("class", "mpr-bc-cell");
        itm.innerText = theDate.getDate();
        return itm;
    }

    getFirstDay() {
        let first = new Date(this.currentYear, this.currentMonth - 1, 1);
        while (first.getDay() != 1) {
            first.setDate(first.getDate() - 1);
        }
        return first;
    }

    getLastDay() {
        let last = new Date(this.currentYear, this.currentMonth, 1);
        last.setDate(last.getDate() - 1);
        while (last.getDay() != 0) {
            last.setDate(last.getDate() + 1);
        }
        last.setDate(last.getDate() + 1);
        return last;
    }

    buildYearSelector() {
        let yearSelector = document.getElementById("mpr-bc-selector-year");
        let currentDate = new Date();
        let start = currentDate.getFullYear() - 1;
        let end = start + 20;
        for (let i = start; i <= end; i++) {
            let opt = document.createElement("option");
            opt.value = i;
            opt.innerText = i;
            yearSelector.appendChild(opt);
        }
    }

    setValues() {
        let yearSelector = document.getElementById("mpr-bc-selector-year");
        let monthSelector = document.getElementById("mpr-bc-selector-month");

        monthSelector.value = this.currentMonth;
        yearSelector.value = this.currentYear;
    }

    callWebService() {
        let xhr = new XMLHttpRequest();
        xhr.onload = () => {
            if(xhr.status >= 200 && xhr.status < 300) {
                console.log("sucess", xhr)
            } else {
                console.error(`Error ${xhr.status}`);
            }
        }
        
        xhr.open("GET", mprbcData.endpoint + "/bcdata/2019/12")
        // xhr.setRequestHeader('X-WP-Nonce', mprbcData.nonces.wp_rest);
        xhr.send();
    }
}

var mprBookingCalendar = new MPR_Bookingcalendar_Client();