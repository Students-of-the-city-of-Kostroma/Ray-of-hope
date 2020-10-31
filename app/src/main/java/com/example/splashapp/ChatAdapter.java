package com.example.splashapp;

import android.content.Context;
import android.graphics.Color;
import android.support.constraint.ConstraintLayout;
import android.support.v7.widget.RecyclerView;
import android.view.Gravity;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;

import com.squareup.picasso.Picasso;

import java.util.ArrayList;
import java.util.List;

public class ChatAdapter extends RecyclerView.Adapter<ChatAdapter.ViewHolder> {

    private List<M_Message> Mes;
    private List<M_Message> itemsCopy=new ArrayList<M_Message>();
    private Context context;
    private ChatAdapter.ItemClickListener mClickListener;

    public ChatAdapter(Context context,List<M_Message> Mes)
    {
        this.Mes=Mes;
        this.context=context;
        itemsCopy.addAll(Mes);
    }

    @Override
    public ChatAdapter.ViewHolder onCreateViewHolder(ViewGroup parent, int ViewType)
    {
        View v = LayoutInflater.from(parent.getContext())
                .inflate(R.layout.message,parent,false);
        return  new ChatAdapter.ViewHolder(v);
    }

    @Override
    public void onBindViewHolder(ChatAdapter.ViewHolder holder, int position) {
        M_Message or=Mes.get(position);
        holder.id=or.getId();
        holder.about.setText(or.getText());
        holder.date.setText(or.getTime().toString());
        if (or.me)
            {
                holder.ln.setGravity(Gravity.RIGHT);
                holder.ln.setBackgroundResource(R.drawable.buttonstyle);
                holder.about.setTextColor(Color.WHITE);
                holder.date.setTextColor(Color.WHITE);
            }
        else
            {
                holder.ln.setGravity(Gravity.LEFT);
                holder.ln.setBackgroundResource(R.drawable.rounded_edittext);
                holder.about.setTextColor(Color.BLACK);
                holder.date.setTextColor(Color.BLACK);

            }
    }

    @Override
    public int getItemCount() {
        return Mes.size();
    }



    public class ViewHolder extends RecyclerView.ViewHolder implements View.OnClickListener {
        public int id;
        public TextView date;
        public TextView about;
        public LinearLayout ln;
        public ConstraintLayout ln1;



        public ViewHolder (View itemView)
        {
            super(itemView);
            date=(TextView) itemView.findViewById(R.id.timems);
            about=(TextView) itemView.findViewById(R.id.textmes);
            ln=(LinearLayout) itemView.findViewById(R.id.ln) ;
            ln1=(ConstraintLayout) itemView.findViewById(R.id.ln1) ;

            itemView.setOnClickListener(this);
        }
        @Override
        public void onClick(View view) {
            if (mClickListener != null) mClickListener.onItemClick(view, getAdapterPosition());
        }
    }

    public M_Message getOrg(int id) {
        return Mes.get(id);
    }

    public void setClickListener(ChatAdapter.ItemClickListener itemClickListener) {
        this.mClickListener = itemClickListener;
    }

    public interface ItemClickListener {
        void onItemClick(View view, int position);
    }
}
