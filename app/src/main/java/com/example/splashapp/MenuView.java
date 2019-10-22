package com.example.splashapp;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.TextView;

public class MenuView extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_another);
    }
    public  void goToMyProfile(View view)
    {
        boolean cit=Choice.citezen;
        if (cit) {
            Intent intent = new Intent(this, CitProf.class);
            startActivity(intent);
        }
        else { Intent intent = new Intent(this, MyOrgProf.class);
            startActivity(intent);}

        finish();
    }

    public  void goToComment(View view)
    {

    }
    public  void goToMarker(View view)
    {

    }
    public  void goToSetting(View view)
    {

    }
    public  void goToFAQ(View view)
    {
        Intent intent = new Intent(this, Q_A.class);
        startActivity(intent);
        finish();
    }
    public  void goToAbout(View view)
    {
        Intent intent = new Intent(this, AboutView.class);
        startActivity(intent);
    }
    public  void goToListOfOrg(View view)
    {
        Intent intent = new Intent(this, ListOfOrg.class);
        startActivity(intent);
        finish();
    }

}
