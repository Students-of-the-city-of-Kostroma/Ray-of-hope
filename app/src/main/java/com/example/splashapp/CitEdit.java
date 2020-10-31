package com.example.splashapp;

import android.content.Intent;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.view.View;

import com.squareup.picasso.Picasso;

public class CitEdit extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_citedit);
        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        ImageView imageView = (ImageView) findViewById(R.id.imageView12);
        Picasso.get().load(R.mipmap.about_logo).into(imageView);

        TextView textview= (TextView) findViewById(R.id.editText);
        textview.setText(C_Citizen.mecit.getFirstName());

        textview= (TextView) findViewById(R.id.editText2);
        textview.setText(C_Citizen.mecit.getLastName());

        textview= (TextView) findViewById(R.id.editText5);
        textview.setText(C_Citizen.mecit.getNumber());

        textview= (TextView) findViewById(R.id.editText10);
        textview.setText(C_Citizen.mecit.getCity());

        textview= (TextView) findViewById(R.id.editText12);
        textview.setText(C_Citizen.mecit.getAbout());
    }
    public void CitEditSave(View view)
    {
        TextView textview= (TextView) findViewById(R.id.editText);
        String s=textview.getText().toString();

        C_Citizen.mecit.setFirstName(s);

        textview= (TextView) findViewById(R.id.editText2);
        s=textview.getText().toString();

        C_Citizen.mecit.setLastName(s);

        textview= (TextView) findViewById(R.id.editText5);
        s=textview.getText().toString();

        C_Citizen.mecit.setNumber(s);

        textview= (TextView) findViewById(R.id.editText10);
        s=textview.getText().toString();

        C_Citizen.mecit.setCity(s);

        textview= (TextView) findViewById(R.id.editText12);
        s=textview.getText().toString();

        C_Citizen.mecit.setAbout(s);

        Intent intent = new Intent(this, CitProf.class);
        startActivity(intent);
        finish();
    }

    public  void ToMyProf(View view)
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
    public  void openMenu(View view)
    {
        Intent intent = new Intent(this, MenuView.class);
        startActivity(intent);
        finish();
    }

    public  void ToListOfOrg(View view)
    {
        Intent intent = new Intent(this, ListOfOrg.class);
        startActivity(intent);
        finish();
    }

}


