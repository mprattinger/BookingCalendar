class MPR_Bookingcalendar_Client { 

    constructor(){
        this.parentDiv = document.getElementsByClassName("mpr-bc-table")[0];
        if(this.parentDiv == null) return;

        let currentDate = new Date();
        this.currentMonth = currentDate.getMonth();
        this.currentYear = currentDate.getFullYear();

        this.setEvents();

        this.buildCalendar();
    }

    buildCalendar() {
        let first = this.getFirstDay();
        let last = this.getLastDay();

        let childs = this.parentDiv.children;
        for (let i = 0; i <= childs.length - 1; i++) {
            let itm = childs[i];
            if(!itm.classList.contains("mpr-bc-header")){
                this.parentDiv.removeChild(itm);
            }
        }

        for(var curr = first; curr < last; first.setDate(first.getDate() + 1)){
            let itm = this.buildDayItem(curr);
            this.parentDiv.appendChild(itm);
        }
        
    }

    setEvents() {
        this.prevToggler = document.getElementById("mpr-bc-toggler-prev");
        this.nextToggler = document.getElementById("mpr-bc-toggler-next")

        this.prevToggler.addEventListener("click", () => {
            this.currentMonth--;
            if(this.currentMonth < 1) {
                this.currentMonth = 12;
                this.currentYear--;
            }
            this.buildCalendar();
        });
        this.nextToggler.addEventListener("click", () => {
            this.currentMonth++;
            if(this.currentMonth > 12) {
                this.currentMonth = 1;
                this.currentYear++;
            }
            this.buildCalendar();
        })
    }

    buildDayItem(theDate){
        let itm = document.createElement("div");
        itm.setAttribute("class", "mpr-bc-cell");
        itm.innerText = theDate.getDate();
        return itm;
    }

    getFirstDay(){
        let first = new Date(this.currentYear, this.currentMonth, 1);
        while(first.getDay() != 1){
            first.setDate(first.getDate() - 1);
        }
        return first;
    }

    getLastDay(){
        let last = new Date(this.currentYear, this.currentMonth + 1, 1);
        last.setDate(last.getDate() - 1);
        while(last.getDay() != 1){
            last.setDate(last.getDate() + 1);
        }
        return last;
    }
}

var mprBookingCalendar = new MPR_Bookingcalendar_Client();