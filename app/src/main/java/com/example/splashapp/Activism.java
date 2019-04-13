package com.example.splashapp;

import javax.validation.constraints.NotNull;
import java.util.Date;

public class Activism extends Post implements Calendar {
    private Date date;

    public Activism(@NotNull int id, @NotNull String name, @NotNull String description, @NotNull Date postDate,
                    @NotNull Date date) {
        super(id, name, description, postDate);
        this.date = date;
    }

    public Date getDate() {
        return date;
    }

    public void setDate(Date date) {
        this.date = date;
    }
}