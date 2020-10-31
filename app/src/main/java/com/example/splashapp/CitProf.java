package com.example.splashapp;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.TextView;

import com.squareup.picasso.Picasso;

public class CitProf extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_cit_prof2);


        TextView textview= (TextView) findViewById(R.id.textname);
        textview.setText(C_Citizen.mecit.getFirstName()+" "+C_Citizen.mecit.getLastName());

        textview= (TextView) findViewById(R.id.menumber);
        textview.setText(C_Citizen.mecit.getNumber());

        textview= (TextView) findViewById(R.id.mecity);
        textview.setText(C_Citizen.mecit.getCity());

        textview= (TextView) findViewById(R.id.meabout);
        textview.setText(C_Citizen.mecit.getAbout());

        ImageView imageView = (ImageView) findViewById(R.id.imageView12);
        Picasso.get().load(R.mipmap.about_logo).into(imageView);
    }

    public void CitEdit(View view)
    {
        Intent intent = new Intent(this, CitEdit.class);
        startActivity(intent);
        finish();
    }

    public void ToLenta(View view)
    {
        Intent intent = new Intent(this, LentaActivity.class);
        startActivity(intent);
        finish();
    }

    public  void ToChoice(boolean b)
    {
        if (b){
            Intent intent = new Intent(this, Choice.class);
            startActivity(intent);
            finish();}
    }
    public  void openMenu(View view)
    {
        Intent intent = new Intent(this, MenuView.class);
        startActivity(intent);
        finish();
    }
    public void ToChats(View view)
    {
        Intent intent = new Intent(this, ListOfChats.class);
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
