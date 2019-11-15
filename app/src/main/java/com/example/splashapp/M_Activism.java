package com.example.splashapp;

import javax.validation.constraints.NotNull;
import java.util.Date;

public class M_Activism extends M_Post{
    private Date date;

    public M_Activism(@NotNull String id, @NotNull String name, @NotNull String description, @NotNull Date postDate,
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