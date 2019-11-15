package com.example.splashapp;

public abstract class ControllerUser {

    public ControllerUser() { }

    public abstract M_User Update(M_User dataNewInput);

    public abstract M_User Autorization(M_User dataInput);

    public abstract M_User Registration(M_User dataInput);

    public abstract M_User getDateProfile ();
}
