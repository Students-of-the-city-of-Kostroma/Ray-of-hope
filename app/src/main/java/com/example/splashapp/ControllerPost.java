package com.example.splashapp;

public abstract class ControllerPost {

    public ControllerPost() { }

    public abstract Post Add(Post post);

    public abstract Post Update(Post post);

    public abstract Post Delete(Post post);

}
