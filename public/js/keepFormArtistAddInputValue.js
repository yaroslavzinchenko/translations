document.getElementById("artist_en").value = getSavedValue("artist_en");
document.getElementById("artist_ru").value = getSavedValue("artist_ru");

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
