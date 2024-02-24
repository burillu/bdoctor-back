import "./bootstrap";
import "~resources/scss/app.scss";
import * as bootstrap from "bootstrap";
import.meta.glob(["../img/**", "../fonts/**"]);
import { calendarJs } from "./calendarJs/calendar.js";


// calendar.js

let calendarInstance1 = new calendarJs("calendar1", {
    exportEventsEnabled: true,
    useAmPmForTimeDisplays: true
}),
    calendarInstance2 = new calendarJs("calendar2", {
        exportEventsEnabled: false,
    });

document.title += " v" + calendarInstance1.getVersion();

let event1 = {
    from: new Date(),
    to: new Date(),
    title: "New Event 1",
    description: "A description of the new event"
},
    event2 = {
        from: new Date(),
        to: new Date(),
        title: "New Event 2",
        description: "A description of the new event"
    };

calendarInstance1.addEvent(event1);
calendarInstance2.addEvent(event2);