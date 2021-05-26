package com.example.splashapp;

import javax.validation.constraints.NotNull;
import java.util.Date;

public class M_Activism extends M_Post{
    //private Date date;

    public M_Activism(@NotNull String id, @NotNull String name, @NotNull String description, @NotNull String org_name ) {
        super(id, name, description, org_name);
        //this.date = date;
    }
}