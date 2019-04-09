package com.example.splashapp;

import android.content.Intent;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.view.View;

public class Citedit extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_citedit);
        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        EditText editText= (EditText) findViewById(R.id.editText3);
        TextView textview= (TextView) findViewById(R.id.textView6);
        editText.setText(textview.getText().toString());
    }
    public void CitEditSave(View view)
    {
        //тут должен быть какой-то код на сохранение
        finish();
    }
    public void CitEditCan(View view)
    {
        finish();
    }

}


