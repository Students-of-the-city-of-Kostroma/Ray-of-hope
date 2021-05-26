package com.example.splashapp;

import javax.validation.constraints.NotNull;
import java.util.Date;
import java.util.List;

public abstract class M_Post {
    private String title, text, org_name, date_added;
    private String id;
    private String[] photo;
    //private Date date;
    public List<M_Comment> linkComment;

    public M_Post(String id, @NotNull String name, @NotNull String description, @NotNull String org_name) {
        this.id=id;
        this.title = name;
        this.text = description;
        this.org_name = org_name;
        //this.date_added = postDate;
    }

    public class ImageClass
    {
        String photo;
    }

    public String getId() {
        return id;
    }

    public void setId(@NotNull String id) {
        this.id = id;
    }

    public String getName() {
        return title;
    }

    public void setName(@NotNull String name) {
        this.title = name;
    }

    public String getDescription() {
        return text;
    }

    public void setDescription(@NotNull String description) {
        this.text = description;
    }

    public String getOrgName() {
        return org_name;
    }

    public void setOrg_name(@NotNull String name) {
        this.org_name = name;
    }

    public String getPostDate() {
        return date_added;
    }

    public void setPostDate(@NotNull String postDate) {
        this.date_added = postDate;
    }

    public String getImage(int i)
    {
        if (photo[i] !=null)
            return "http://darapana.beget.tech/storage/app/"+ photo[i];
        else return null;
    }
    public int getCountImage()
    { if (photo!=null)
        return photo.length;
    else return 0;}

    public boolean CreateComment (String text)
    {
        return false;
    }

    public List<M_Comment> getLinkComment(){return linkComment;}
}
