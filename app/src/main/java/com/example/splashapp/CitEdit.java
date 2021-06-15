package com.example.splashapp;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AlertDialog;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.View;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.view.View;

import com.squareup.picasso.Picasso;

import java.io.File;
import java.io.FileInputStream;
import java.io.FileNotFoundException;
import java.io.InputStream;

public class CitEdit extends AppCompatActivity {

    ImageView imageView;
    Bitmap selectedImage;
    Boolean pe = false;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_citedit);
        Toolbar toolbar = findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);

        imageView = (ImageView) findViewById(R.id.imageView12);


        ImageView imageView = (ImageView) findViewById(R.id.imageView12);
        if (C_Citizen.Iam.getImageName()!=null) {
            try {
                imageView.setImageBitmap(C_Citizen.Iam.getImageHash());
                //Picasso.get().load(C_Citizen.Iam.getImageName()).into(imageView);
            } catch (Exception e) {
                Picasso.get().load(R.mipmap.about_logo).into(imageView);
            }
        }
        else {
            Picasso.get().load(R.mipmap.about_logo).into(imageView);
        }

        TextView textview = (TextView) findViewById(R.id.editText);
        textview.setText(C_Citizen.Iam.getFirstName());

        textview = (TextView) findViewById(R.id.editText2);
        textview.setText(C_Citizen.Iam.getLastName());

        textview = (TextView) findViewById(R.id.editTextO);
        textview.setText(C_Citizen.Iam.getOName());


        textview = (TextView) findViewById(R.id.editText5);
        textview.setText(C_Citizen.Iam.getNumber());

        textview = (TextView) findViewById(R.id.editText10);
        textview.setText(C_Citizen.Iam.getCity());

        textview = (TextView) findViewById(R.id.editText12);
        textview.setText(C_Citizen.Iam.getAbout());
    }

    public void PhotoEdit(View view) {
        Intent photoPickerIntent = new Intent(Intent.ACTION_PICK);
        photoPickerIntent.setType("image/*");
        startActivityForResult(photoPickerIntent, 0);
    }


    @Override
    protected void onActivityResult(int reqCode, int resultCode, Intent data) {
        super.onActivityResult(reqCode, resultCode, data);


        if (resultCode == -1) {
            try {
                pe = true;
                final Uri imageUri = data.getData();
                final InputStream imageStream = getContentResolver().openInputStream(imageUri);
                selectedImage = BitmapFactory.decodeStream(imageStream);
                imageView.setImageBitmap(selectedImage);
            } catch (FileNotFoundException e) {
                e.printStackTrace();
            }
        }
    }

    public void CitEditSave(View view) {
        Network upd = new Network();
        if (pe) {
            upd.updImgae(new String[]{C_Citizen.Iam.getId()}, selectedImage);
        }


        TextView textview = (TextView) findViewById(R.id.editText);
        String s = textview.getText().toString();

        if (!C_Citizen.Iam.getFirstName().equals(s)) {
            C_Citizen.Iam.setFirstName(s);
            upd.UpdCit(new String[]{"name", "name", s, C_Citizen.Iam.getId()});
        }

        textview = (TextView) findViewById(R.id.editText2);
        s = textview.getText().toString();

        if (!C_Citizen.Iam.getLastName().equals(s)) {
            C_Citizen.Iam.setLastName(s);
            upd.UpdCit(new String[]{"fname", "fname", s, C_Citizen.Iam.getId()});
        }

        textview = (TextView) findViewById(R.id.editTextO);
        s = textview.getText().toString();

        if ((C_Citizen.Iam.getOName() == null && s != null) || (!C_Citizen.Iam.getOName().equals(s))) {
            C_Citizen.Iam.setOtName(s);
            upd.UpdCit(new String[]{"oname", "oname", s, C_Citizen.Iam.getId()});
        }


       /* textview = (TextView) findViewById(R.id.editText5);
        s = textview.getText().toString();

        if (C_Citizen.Iam.getNumber() != null && !C_Citizen.Iam.getNumber().equals(s)) {
            C_Citizen.Iam.setNumber(s);
            upd.UpdCit(new String[]{"telephone", "tel", s, C_Citizen.Iam.getId()});
        }


        textview = (TextView) findViewById(R.id.editText10);
        s = textview.getText().toString();

        if (C_Citizen.Iam.getCity() != null && !C_Citizen.Iam.getCity().equals(s)) {
            C_Citizen.Iam.setCity(s);
            upd.UpdCit(new String[]{"city", "city", s, C_Citizen.Iam.getId()});
        } */


        textview = (TextView) findViewById(R.id.editText12);
        s = textview.getText().toString();

        //if (!C_Citizen.Iam.getAbout().equals(s)) {
        C_Citizen.Iam.setAbout(s);
        upd.UpdCit(new String[]{"description", "description", s, C_Citizen.Iam.getId()});
        // }


        Intent intent = new Intent(this, CitProf.class);
        startActivity(intent);
        finish();
    }

    @Override
    public void onBackPressed() {
        Cancel(CitProf.class);
    }

    public void Cancel(Class<?> t)
    {
        Context c=this;
        Class<?> x=t;
        AlertDialog.Builder adb = new AlertDialog.Builder(this);
        adb.setMessage("Отменить изменения?");
        adb.setNegativeButton("Нет", new DialogInterface.OnClickListener(){
            @Override
            public void onClick(DialogInterface d, int arg1) {
                return;
            };
        });
        adb.setPositiveButton("Да", new DialogInterface.OnClickListener(){
            @Override
            public void onClick(DialogInterface d, int arg1) {
                Intent intent = new Intent(c, t);
                startActivity(intent);
                finish();
            };
        });

        adb.show();
    }

    public void ToMyProf(View view) {
        Cancel(CitProf.class);
    }

    public void openMenu(View view) {
        Cancel(MenuView.class);
    }

    public void ToListOfOrg(View view) {
        Cancel(ListOfOrg.class);
    }
    public void ToLenta(View view) {
        Cancel(LentaActivity.class);
    }
    public void ToChats(View view) {
        Cancel(ListOfChats.class);
    }


}


