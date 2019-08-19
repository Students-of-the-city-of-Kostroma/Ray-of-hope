package com.example.splashapp;

import android.content.Intent;
import android.os.Bundle;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;

public class Choice extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.choice);

    }
    public static boolean citezen=true;

        public void CitChoice(View view)
        {
            citezen=true;
            Perehod();
        }
        public void OrgChoice(View view)
        {
            citezen=false;
            //Perehod();
            Intent intent = new Intent(this, RegOrg.class);
            startActivity(intent);
            finish();
        }
    public  void Perehod()
    {
        Intent intent = new Intent(this, AboutView.class);
        startActivity(intent);
        finish();
    }

}
