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
    let x = document.getElementById("divContents" + station_id);

    //Here we're defining if it's EVEN or ODDS
    if (station_id % 2 === 1)
    {
        //This is when you're closing the ODD div
        if (current_div.classList.contains('col-md-12'))
        {
            current_div.classList.remove('col-md-12');
            next_div.hidden = false;
            x.hidden = true;
        }
        // This is when you're opening the ODD div
        else
        {
            current_div.classList.add('col-md-12');
            next_div.hidden = true;
            x.hidden = false;
        }
    }
    else
        {
            //This is when you're closing the EVEN div
            if (current_div.classList.contains('col-md-12'))
            {
                current_div.classList.remove('col-md-12');
                previous_div.hidden = false;
                x.hidden = true;
            }
            //This is when you're opening the EVEN div
            else
            {
                current_div.classList.add('col-md-12');
                previous_div.hidden = true;
                x.hidden = false;
            }
        }
}
