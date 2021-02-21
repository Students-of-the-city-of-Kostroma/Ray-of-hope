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
        textview.setText(C_Citizen.Iam.getFirstName());

        textview= (TextView) findViewById(R.id.editText2);
        textview.setText(C_Citizen.Iam.getLastName());

        textview= (TextView) findViewById(R.id.editTextO);
        textview.setText(C_Citizen.Iam.getOName());


        textview= (TextView) findViewById(R.id.editText5);
        textview.setText(C_Citizen.Iam.getNumber());

        textview= (TextView) findViewById(R.id.editText10);
        textview.setText(C_Citizen.Iam.getCity());

        textview= (TextView) findViewById(R.id.editText12);
        textview.setText(C_Citizen.Iam.getAbout());
    }
    public void CitEditSave(View view)
    {
        Network upd=new Network();
        TextView textview= (TextView) findViewById(R.id.editText);
        String s=textview.getText().toString();

        if (!C_Citizen.Iam.getFirstName().equals(s)) {
            C_Citizen.Iam.setFirstName(s);
            upd.UpdCit(new String[]{"name","name", s, C_Citizen.Iam.getId()});
        }

        textview= (TextView) findViewById(R.id.editText2);
        s=textview.getText().toString();

        if (!C_Citizen.Iam.getLastName().equals(s)) {
            C_Citizen.Iam.setLastName(s);
            upd.UpdCit(new String[]{"fname","f_name", s, C_Citizen.Iam.getId()});
        }

        textview= (TextView) findViewById(R.id.editTextO);
        s=textview.getText().toString();

        if (!C_Citizen.Iam.getOName().equals(s)) {
            C_Citizen.Iam.setOtName(s);
            upd.UpdCit(new String[]{"oname","o_name", s, C_Citizen.Iam.getId()});
        }


        textview= (TextView) findViewById(R.id.editText5);
        s=textview.getText().toString();

        if (C_Citizen.Iam.getNumber()!=null &&!C_Citizen.Iam.getNumber().equals(s)) {
            C_Citizen.Iam.setNumber(s);
            upd.UpdCit(new String[]{"telephone","tel", s, C_Citizen.Iam.getId()});
        }


        textview= (TextView) findViewById(R.id.editText10);
        s=textview.getText().toString();

        if (C_Citizen.Iam.getCity()!=null &&!C_Citizen.Iam.getCity().equals(s)) {
            C_Citizen.Iam.setCity(s);
            upd.UpdCit(new String[]{"city","city", s, C_Citizen.Iam.getId()});
        }


        textview= (TextView) findViewById(R.id.editText12);
        s=textview.getText().toString();

        //if (!C_Citizen.Iam.getAbout().equals(s)) {
            C_Citizen.Iam.setAbout(s);
            upd.UpdCit(new String[]{"description","description", s, C_Citizen.Iam.getId()});
       // }


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


