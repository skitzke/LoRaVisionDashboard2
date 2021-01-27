// This script is to attach a hidden and unhidden option to the DIV that it's being assigned to
// Currently this script is only being used for Alerts.
function show_form(option_id) {
    let form = document.getElementById(option_id + '-form');
    form.hidden = form.hidden !== true;
}

// This will give each box an ID for a station and assign them according to even and odds.
function show_station_data(station_id)
{
    let current_div = document.getElementById('station' + station_id);
    let next_div = document.getElementById('station' + (station_id + 1));
    let previous_div = document.getElementById('station' + (station_id - 1));
    let div_contents = document.getElementById("divContents" + station_id);

    //Here we're defining if it's EVEN or ODDS
    if (station_id % 2 === 1)
    {
        //This is when you're closing the ODD div
        if (current_div.classList.contains('stationSize'))
        {
            current_div.classList.remove('stationSize');
            div_contents.classList.add('openCloseContents');
            next_div.hidden = false;
        }
        // This is when you're opening the ODD div
        else
        {
            current_div.classList.add('stationSize');
            setTimeout(function(){div_contents.classList.remove('openCloseContents');}, 400);
            next_div.hidden = true;
        }
    }
    else
    {
        //This is when you're closing the EVEN div
        if (current_div.classList.contains('stationSize'))
        {
            current_div.classList.remove('stationSize');
            div_contents.classList.add('openCloseContents');
            previous_div.hidden = false;
        }
        //This is when you're opening the EVEN div
        else
        {
            current_div.classList.add('stationSize');
            setTimeout(function(){div_contents.classList.remove('openCloseContents');}, 400);
            previous_div.hidden = true;
        }
    }

}
