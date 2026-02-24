import Plyr from "plyr";

document.addEventListener("alpine:init", () => {
    Alpine.data(
        "lessonPlayer",
        ({ progressUrl, completeUrl, csrfToken, isEnrolled }) => ({
            player: null,
            lastSavedSeconds: 0,
            saveIntervalSeconds: 10,
            progressUrl,
            completeUrl,
            csrfToken,
            isEnrolled,

            init() {
                this.player = new Plyr(this.$refs.video, {
                    controls: [
                        "play-large",
                        "play",
                        "progress",
                        "current-time",
                        "mute",
                        "volume",
                        "captions",
                        "settings",
                        "pip",
                        "airplay",
                        "fullscreen",
                    ],
                });

                if (this.isEnrolled && this.progressUrl) {
                    this.player.on("timeupdate", () => this.onTimeUpdate());
                    this.player.on("ended", () => this.onEnded());
                }
            },

            onTimeUpdate() {
                const currentSeconds = Math.floor(this.player.currentTime);
                if (
                    currentSeconds - this.lastSavedSeconds >=
                    this.saveIntervalSeconds
                ) {
                    this.lastSavedSeconds = currentSeconds;
                    this.saveProgress(currentSeconds);
                }
            },

            onEnded() {
                if (this.completeUrl) {
                    this.markComplete();
                }
            },

            async saveProgress(watchSeconds) {
                try {
                    await fetch(this.progressUrl, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": this.csrfToken,
                        },
                        body: JSON.stringify({ watch_seconds: watchSeconds }),
                    });
                } catch (e) {
                    console.error("Failed to save lesson progress:", e);
                }
            },

            markComplete() {
                const form = document.createElement("form");
                form.method = "POST";
                form.action = this.completeUrl;
                const csrf = document.createElement("input");
                csrf.type = "hidden";
                csrf.name = "_token";
                csrf.value = this.csrfToken;
                form.appendChild(csrf);
                document.body.appendChild(form);
                form.submit();
            },

            destroy() {
                if (this.player) {
                    this.player.destroy();
                    this.player = null;
                }
            },
        }),
    );
});
