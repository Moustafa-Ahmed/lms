import "./player.js";

document.addEventListener("livewire:initialized", function () {
    const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

    Livewire.dispatch("updateUserTimezone", { timezone });
});
