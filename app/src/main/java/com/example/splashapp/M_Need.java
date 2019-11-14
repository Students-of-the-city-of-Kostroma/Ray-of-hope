package com.example.splashapp;
import javax.validation.constraints.NotNull;
import java.util.Date;

public class Need extends M_Post {
    private String whatNeed;
    private int percent;

    public Need(@NotNull String id, @NotNull String name, @NotNull String description, @NotNull Date postDate,
                @NotNull String whatNeed, @NotNull int percent) {
        super(id, name, description, postDate);
        this.whatNeed = whatNeed;
        this.percent = percent;
    }

    public String getWhatNeed() {
        return whatNeed;
    }

    public void setWhatNeed(@NotNull String whatNeed) {
        this.whatNeed = whatNeed;
    }

    public int getPercent() {
        return percent;
    }

    public void setPercent(int percent) {
        this.percent = percent;
    }
}