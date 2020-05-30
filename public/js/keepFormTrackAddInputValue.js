document.getElementById("track_name_en").value = getSavedValue("track_name_en");
document.getElementById("track_name_ru").value = getSavedValue("track_name_ru");
document.getElementById("lyrics").value = getSavedValue("lyrics");
document.getElementById("spotify_link").value = getSavedValue("spotify_link");
document.getElementById("youtube_link").value = getSavedValue("youtube_link");

// Save the value function - save it to sessionStorage as (ID, VALUE).
function saveValue(e)
{
    let id = e.id; // Get the sender's id to save it.
    let value = e.value; // Get the value.
    sessionStorage.setItem(id, value); // Every time user writing something, the sessionStorage's value will override.
}

// Get the saved value function - return the value of "v" from sessionStorage.
function getSavedValue(v)
{
    if (!sessionStorage.getItem(v))
    {
        return ""; // You can change this to your default value.
    }
    return sessionStorage.getItem(v);
}
